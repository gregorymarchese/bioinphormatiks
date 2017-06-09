import numpy as np
import scipy.io
import sys
from keras.models import Sequential
from keras.layers import Convolution1D
from keras.layers import MaxPooling1D
from keras.layers import Dense
from keras.layers import Dropout
from keras.layers import Flatten
from keras.layers import BatchNormalization
from keras.layers import Activation
from keras.utils.vis_utils import plot_model
import pandas as pd
from keras.utils.np_utils import to_categorical
from keras.optimizers import SGD
import pydot_ng
from keras.regularizers import l2
from keras.constraints import non_neg





def process_data(train_promoters, train_activities, test_promoters, test_activities):
    train_promoter_array = []
    train_activities_array = []
    test_promoters_array = []
    test_activities_array = []
    test_ids = []
    max_length = 0
    for id in train_promoters:
        if len(train_promoters[id]) > max_length:
            max_length = len(train_promoters[id])
    for id in test_promoters:
        if len(test_promoters[id]) > max_length:
            max_length = len(test_promoters[id])

    print("max length is: " + str(max_length))
    for id in train_promoters:
        promoter = train_promoters[id]
        for i in range(max_length - len(promoter)):
            promoter+="A"
        train_promoter_array.append(promoter)
        train_activities_array.append(int(train_activities[id]))
    for id in test_promoters:
        promoter = test_promoters[id]
        for i in range(max_length - len(promoter)):
            promoter+= "A"
        test_promoters_array.append(promoter)
        test_activities_array.append(int(test_activities[id]))
        test_ids.append(id)
    preprocessed_train_promoters = np.array([[int(x) for x in s.translate(str.maketrans('ACGT','0123'))] for s in train_promoter_array])

    preprocessed_train_activites = np.array([to_categorical(act,5) for act in train_activities_array]).reshape(90,5)

    print("shape is: " + str(np.shape(preprocessed_train_activites)))
    preprocessed_test_promoters = np.array([[int(x) for x in s.translate(str.maketrans('ACGT', '0123'))] for s in
                                            list(test_promoters_array)])
    preprocessed_test_activities = np.array([to_categorical(act,5) for act in test_activities_array]).reshape(53,5)




    preprocessed_train_promoters = np.asarray([to_categorical(prom,4) for prom in preprocessed_train_promoters], dtype='float32')
    preprocessed_test_promoters = np.asarray([to_categorical(prom,4) for prom in preprocessed_test_promoters], dtype='float32')
    print("shape is now: " + str(np.shape(preprocessed_train_promoters)))



    return preprocessed_train_promoters, preprocessed_train_activites, preprocessed_test_promoters, \
           preprocessed_test_activities, test_ids

#Simple conv neural network
def convolutional_neural_network(train_data, train_activities, depth):
    print("Building model....")

    print("shape is: " + str(np.shape(train_data)))
    model = Sequential()
    model.add(Convolution1D(filters=200, kernel_size=4, padding='valid', activation='relu', subsample_length=1,
                            input_shape=(np.shape(train_data)[1],4),
                            activity_regularizer=l2(0.01)))

    model.add(MaxPooling1D(pool_size=30, strides=10))
    model.add(BatchNormalization())
    model.add(Dropout(0.5))
    model.add(Flatten())
    model.add(Dense(5, activation='softmax'))


    sdg = SGD(lr=0.1, decay=1e-6, momentum=0.9, nesterov=True)
    model.compile(loss='categorical_crossentropy', optimizer='adam')
    print("Training....")
    hist = model.fit(train_data, train_activities, batch_size=30, epochs=10, shuffle=True)
    print(hist.history)

    return model

def test_data(test_data, test_activities, model, test_ids):
    print(pydot_ng.find_graphviz())
    plot_model(model, to_file='model.png')
    test = model.evaluate(test_data, test_activities, batch_size = 10, verbose=1, sample_weight=None)

    print("score is: " + str(test))

    test_results = model.predict(test_data)
    print(np.shape(test_results))

    for i, pred in enumerate(test_results):
        print( str(test_ids[i]) + "\t" +  str(pred) )






