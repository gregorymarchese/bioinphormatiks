import math

import numpy as np
from keras.layers import BatchNormalization
from keras.layers import Convolution1D
from keras.layers import Dense
from keras.layers import Dropout
from keras.layers import Flatten
from keras.layers import MaxPooling1D
from keras.models import Sequential
from keras.optimizers import SGD
from keras.regularizers import l2
from keras.utils import plot_model
from keras.utils.np_utils import to_categorical
import pydot_ng as pydot_ng

from keras.models import model_from_json


import proml_lib as proml_lib


def process_data(train_promoters, train_activities, test_promoters, test_activities):
    print("length is: " + str(len(train_activities)))
    train_promoter_array = []
    train_activities_array = []
    test_promoters_array = []
    test_activities_array = []
    test_ids = []
    preprocessed_train_promoters = None
    preprocessed_train_activites = None
    max_length = 0
    if len(train_promoters) > 0:
        for id in train_promoters:
            if len(train_promoters[id]) > max_length:
                max_length = len(train_promoters[id])
        for id in train_promoters:
            promoter = train_promoters[id]
            for i in range(max_length - len(promoter)):
                promoter += "A"
            train_promoter_array.append(promoter)
            train_activities_array.append(int(round(train_activities[id], 3) * 100))
        preprocessed_train_promoters = np.array(
            [[int(x) for x in s.translate(str.maketrans('ACGT', '0123'))] for s in train_promoter_array])

        preprocessed_train_activites = np.array([to_categorical(act, 400) for act in train_activities_array]).reshape(
            90, 400)

        preprocessed_train_promoters = np.asarray([to_categorical(prom, 4) for prom in preprocessed_train_promoters],
                                                  dtype='float32')

    else:
        max_length = 6418
    for id in test_promoters:
        if len(test_promoters[id]) > max_length:
            max_length = len(test_promoters[id])



    for id in test_promoters:
        promoter = test_promoters[id]
        for i in range(max_length - len(promoter)):
            promoter+= "A"
        test_promoters_array.append(promoter)
        test_activities_array.append(int(round(test_activities[id], 3) * 100))
        test_ids.append(id)


    preprocessed_test_promoters = np.array([[int(x) for x in s.translate(str.maketrans('ACGT', '0123'))] for s in
                                            list(test_promoters_array)])
    preprocessed_test_activities = np.array([to_categorical(act,400) for act in test_activities_array]).reshape(53,400)




    preprocessed_test_promoters = np.asarray([to_categorical(prom,4) for prom in preprocessed_test_promoters], dtype='float32')



    return preprocessed_train_promoters, preprocessed_train_activites, preprocessed_test_promoters, \
           preprocessed_test_activities, test_ids


#Simple conv neural network
def convolutional_neural_network(train_data, train_activities, job_number, epochs):
    print("Building model....")

    model = Sequential()
    model.add(Convolution1D(filters=100, kernel_size=4, padding='valid', activation='relu', subsample_length=1,
                            input_shape=(np.shape(train_data)[1],4),
                            activity_regularizer=l2(0.01)))
    model.add(Convolution1D(filters=200, kernel_size=4, padding='valid', activation='relu', activity_regularizer=l2(0.01)))
    model.add(MaxPooling1D(pool_size=20, strides=20))
    model.add(BatchNormalization())
    model.add(Dropout(0.5))
    model.add(Flatten())
    model.add(Dense(400, activation='softmax'))


    sdg = SGD(lr=0.1, decay=1e-6, momentum=0.9, nesterov=True)
    model.compile(loss='categorical_crossentropy', optimizer='adam')
    print("Training....")
    proml_lib.updateJobConfig(job_number, 'model_train')
    proml_lib.sendMessage(job_number, 'model_train')
    hist = model.fit(train_data, train_activities, batch_size=10, epochs=epochs, shuffle=True)
    print(hist.history)

    loss_array = hist.history

    serialize_model(model)
    return model, loss_array


def calculate_scores(test_result):
    score = 0.0
    for i in range(len(test_result)):
        result = test_result[i]
        score += result*i

    return score


def output_files(loss_array, predictions, loss_output_file_name, pred_output_file_name, job_number):
    loss_output_file = open(loss_output_file_name, "w+")
    pred_output_file = open(pred_output_file_name, "w+")

    if loss_array != None:

        loss_output_file.write("epoch" + "\t" + "categorical crossentropy loss" + "\n")

        for i in range(len(loss_array['loss'])):
            loss_output_file.write(str(i) + "\t" + str(loss_array['loss'][i]) + "\n")

    pred_output_file.write("Promoter" + "\t" + "Predicted Expression" + "\n")
    for id in predictions:
        pred_output_file.write(str(id) + "\t" + str(predictions[id]*0.01) + "\n")

    proml_lib.sendMessage(job_number, 'complete')
    proml_lib.updateJobConfig(job_number, 'complete')



def serialize_model(model):
    model_json = model.to_json()
    with open("models/model.json", "w+") as json_model_file:
        json_model_file.write(model_json)

    model.save_weights("models/model.h5")



def test_data(test_data, test_activities, model, test_ids, job_number):

    if model == None:
        json_file = open('models/model.json', "r")
        model_json = json_file.read()
        json_file.close()
        model = model_from_json(model_json)
        model.load_weights('models/model.h5')
        model.compile(loss='categorical_crossentropy', optimizer='adam')

    print(pydot_ng.find_graphviz())
    plot_model(model, to_file='model.png')
    test = model.evaluate(test_data, test_activities, batch_size = 10, verbose=1, sample_weight=None)
    proml_lib.updateJobConfig(job_number, 'job_execute')


    print("score is: " + str(test))

    test_results = model.predict(test_data)
    print(np.shape(test_results))

    pred_outputs = {}

    for i, pred in enumerate(test_results):
        print( str(test_ids[i]) + "\t" +  str(np.argmax(pred) * 0.01))

        pred_outputs[test_ids[i]] = calculate_scores(pred)

    return pred_outputs





