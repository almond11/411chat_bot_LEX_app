import csv

with open('l.csv', 'r') as f2:
    with open('ll.txt', mode='w') as infile:
        reader = csv.reader(f2)
        for row in reader:  # content is all the other lines
            
            try:
                infile.write(row[0].strip())  # writing line without last comma
            except Exception:
                pass
                