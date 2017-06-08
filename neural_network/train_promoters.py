import numpy as np
import scipy.io
import sys
from keras.models import Sequential
from keras.layers import Conv1D
from keras.layers import MaxPooling1D
from keras.layers import Dense
from keras.layers import Dropout
from keras.layers import Flatten
from keras.layers import BatchNormalization
from keras.layers import Activation
from keras.utils.vis_utils import plot_model
import pandas as pd
from keras.optimizers import SGD
import pydot_ng





def process_data(promoters, activities):
    train_data = np.array([])
    train_activities = np.array([])
    for id in promoters:
        promoter = promoters[id]
        activity = activities[id]
        # print("shape is: " + str(np.shape(promoter)))
        train_data = np.append(train_data, promoter, axis=0)
        train_activities = np.append(train_activities, activity, axis=0)

    print("train data: " + str(train_data))
    return train_data, train_activities


#Simple conv neural network
def convolutional_neural_network(train_data, train_activities, depth):
    print("Building model....")
    model = Sequential()
    model.add(Conv1D(filters=100, kernel_size=20, padding="valid", activation="relu", input_shape=(None, depth)))
    model.add(BatchNormalization())
    model.add(Conv1D(filters=200, kernel_size=20, padding="valid", activation="relu"))
    model.add(MaxPooling1D(pool_size=40, strides=40))
    model.add(BatchNormalization())
    model.add(Dropout(0.2))
    model.add(Dense(1))


    sdg = SGD(lr=0.1, decay=1e-6, momentum=0.9, nesterov=True)
    model.compile(loss='mse', optimizer='adam')
    print("Training....")
    hist = model.fit(train_data, train_activities, batch_size=100, epochs=2, shuffle=True)
    print(hist.history)

    return model

def test_data(test_data, test_activities, model, ids):
    print(pydot_ng.find_graphviz())
    plot_model(model, to_file='model.png')
    test = model.evaluate(test_data, test_activities, batch_size = 26, verbose=1, sample_weight=None)

    print("score is: " + str(test))

    test_results = model.predict(test_data, batch_size=32)
    result = test_results[:,0]

    for i, pred in enumerate(result):
        print(str(ids[i]) + "\t" + str(pred) )






