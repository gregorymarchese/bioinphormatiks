import sys, getopt
import math
import itertools
import numpy as np
import train_promoters as tp



def assemble_sequences(input_file, flanking_seq,  activities):
    flank_seqs = []
    for line in open(flanking_seq, "r"):
        if line.startswith(">"):
            continue
        else:
            flank_seqs.append(line)

    print("before seq is: " + flank_seqs[0])
    print("after seq is: " + flank_seqs[1])

    input_seq_dict = {}
    input_seqs = open(input_file, "r").read().split("\n")

    for i in range(len(input_seqs)):
        line = input_seqs[i]
        if line.startswith(">"):
            rs_id = line.replace(">","")
            seq = input_seqs[i+1].replace("N","")
            total_seq = flank_seqs[0] + seq + flank_seqs[1]
            total_seq = total_seq.replace("\r","").replace("\n","")
            input_seq_dict[rs_id] = total_seq
        else:
            continue

    activity_vals = open(activities, "r").read().split("\n")
    activities_dict = {}

    max_activity = 0
    for i in range(len(activity_vals)):
        line = activity_vals[i].split("\t")
        if len(line) == 2:
            id = line[0]
            activity = float(line[1])
            if activity > max_activity:
                max_activity = activity

            activities_dict[id] = activity


    return input_seq_dict,activities_dict


def process_activities(activities_dict):
    new_activities_dict = {}
    for id in activities_dict:
        activity_array = [0 for i in range(400)]
        activity = int(activities_dict[id] * 100)
        activity_array[activity] = 1
        new_activities_dict[id] = activity_array

    return new_activities_dict




def create_dictionary(k):
    nucleotides = ["A", "C", "G", "T"]

    dictionary = [''.join(p) for p in itertools.product(nucleotides, repeat=k)]

    one_hot_dictionary = {}
    for i in range(len(dictionary)):
        seq = dictionary[i]
        one_hot_array = [0 for j in range(int(math.pow(4,k)))]
        one_hot_array[i] = 1
        one_hot_dictionary[seq] = one_hot_array

    # for kmer in one_hot_dictionary:
        # print("kmer : " + st    r(kmer) + " " + str(one_hot_dictionary[kmer]))
    return one_hot_dictionary



def preprocess_data(k, w, input_seq_dict, one_hot_dictionary, activities_dict, max_length):

    one_hot_input_seq_dictionary = {}
    maximum = 0
    kmers_dict = {}
    for id in input_seq_dict:
        seq = input_seq_dict[id]
        # print("seq is: " + str(seq))
        kmers = []
        for i in range(len(seq) - k + 1):
            kmer=seq[i:i+k]
            kmers.append(kmer)
        if len(kmers) > maximum:
            maximum = len(kmers)
        # print("kmers is: " + str(kmers))
        kmers_dict[id] = kmers

    print("maximum is: " + str(maximum))

    # TODO change to empty numpy arrays instead of converting at the end
    train_data = []
    train_activities = []
    placeholder_array = [0 for a in range(int(math.pow(4, k)))]
    length = len(kmers_dict)
    i = 0
    ids = []
    for id in kmers_dict:
        print("processing " + str(i) + " of " + str(length))
        i = i + 1
        kmers = kmers_dict[id]
        ids.append(id)
        one_hot_kmer_for_id = []
        for j in range(0,len(kmers)):
            one_hot_kmer = []
            kmer = kmers[j]
            # for x in range(w):
            #     kmer = kmers[j + x]
            #     one_hot_kmer.append(one_hot_dictionary[kmer])

            one_hot_kmer_for_id.append(one_hot_dictionary[kmer])
        for k in range(0, max_length - len(kmers)):
            one_hot_kmer_for_id.append(placeholder_array)
        #print("shape is: " + str(np.shape(one_hot_kmer_for_id)))
        train_data.append(one_hot_kmer_for_id)
        train_activities.append(activities_dict[id])
    print("shape is: " + str(np.shape(train_data)))
    return ids, np.array(train_data), np.array(train_activities).reshape(len(input_seq_dict),1,1)


def main(args):

    k = 0
    w = 0
    job_number = 0
    input_file = ''
    activities = ''
    flanking_seq = ''
    output_file = ''
    test_promoters = ''
    test_promoters_activites = ''

    try:
        opts, args = getopt.getopt(args, "hk:w:i:a:f:t:e:o:j:", ["k=", "w=", "input_file=", "flanking_seq=" "output_file="])
    except:
        print('train_data.py -k <kmer size> -w <window size> -i <training promoters> -f <flanking sequences> '
              '-a <training promoter activities> -t <testing promoters> -e <testing promoter activites> '
              ' -o <output_file>')

    for opt, arg in opts:
        if opt == '-h':
            print('USAGE: python train_data.py -k <kmer size> -w <window size> -i <input_file> -o <output_file>')
        elif opt == '-k':
            k = int(arg)
        elif opt == '-w':
            w = int(arg)
        elif opt == '-i':
            input_file = arg
        elif opt == '-f':
            flanking_seq = arg
        elif opt == '-a':
            activities = arg
        elif opt == '-o':
            output_file = arg
        elif opt == '-t':
            test_promoters = arg
        elif opt == '-e':
            test_promoters_activites = arg
        elif opt == '-j':
            job_number = arg


    print("training promoters file is: " + str(input_file))
    print("training promoter activities file is: " + str(activities))
    print("flanking seq is: " + str(flanking_seq))
    print("output_file is: " + str(output_file))
    print("test promoters file is: " + str(test_promoters))
    print("test promoters activities file is: " + str(test_promoters_activites))

    input_seq_dict, activities_dict = assemble_sequences(input_file, flanking_seq, activities)

    test_promoters_dict, test_activites_dict = assemble_sequences(test_promoters, flanking_seq, test_promoters_activites)



    train_data, train_activities, test_data, test_activities, test_ids = tp.process_data(input_seq_dict, activities_dict,
                                                                               test_promoters_dict, test_activites_dict)
    depth = np.shape(train_data[0])[1]
    print("depth is: " + str(depth))
    model, loss_array = tp.convolutional_neural_network(train_data, train_activities, depth, job_number)

    preds = tp.test_data(test_data, test_activities, model, test_ids, job_number)

    tp.output_files(loss_array, preds, "training_output/" + str(job_number) + ".tsv",
                    "promoter_output/" + str(job_number) + ".tsv")













if __name__ == '__main__':main(sys.argv[1:])