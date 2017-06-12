

actual_values_file = open("../data/dream6_expred_real-data/dream6_expred_predictions_gold_standard_0.txt", "r")
predicted_values_file = open("promoter_output/2.tsv","r")

actual_values = {}
predicted_values ={}

for line in actual_values_file:
    if line.strip() != "":
        actual_values[line.split("\t")[0]] = float(line.split("\t")[1])


for line in predicted_values_file:
    if line.strip() != "" and "Promoter" not in line:
        predicted_values[line.split("\t")[0]] = float(line.split("\t")[1])

average_distance = 0

for id in predicted_values:
    diff = abs(predicted_values[id] - actual_values[id])
    average_distance += diff

average_distance = average_distance/len(predicted_values)

print("average distance is: " + str(average_distance))

