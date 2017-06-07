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
from keras.utils import plot_model
import pandas as pd





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
    model.add(Conv1D(filters=1000, kernel_size=20, padding="valid", activation="relu"))
    model.add(BatchNormalization())
    model.add(MaxPooling1D(pool_size=15, strides=15))
    model.add(Dropout(0.5))
    model.add(Dense(1))


    model.compile(loss='mean_absolute_error', optimizer='rmsprop')
    print("Training....")
    hist = model.fit(train_data, train_activities, batch_size=100, epochs=30, shuffle=True)
    print(hist.history)

    return model

def test_data(test_data, test_activities, model):
    plot_model(model, to_file='model.png')
    test = model.evaluate(test_data, test_activities, batch_size = 26, verbose=1, sample_weight=None)

    for metric in model.metric_names:
        print("metric is: " + str(metric))

    print("score is:  " + str(test))







