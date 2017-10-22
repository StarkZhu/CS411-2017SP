import numpy as np
import heapq
import csv


def read_prop_data(filename):
    """
    read property data from file as 2d array
    :param filename:
    :return:
    """
    f = open(filename, 'r')
    properties = []
    for line in f:
        if len(line) < 5: continue
        data = map(float, line.split(',')[:-3])
        properties.append(data)
    return properties


def read_user_data(filename):
    """
    read user profile data from file
    :param filename:
    :return:
    """
    f = open(filename, 'r')
    user = []
    for line in f:
        data = line.split(',')
        user.append(data)
    return user


def read_major_coord():
    """
    load major's coordniates from file
    :return: dictionary of majors
    """
    f = open('major_coord.txt')
    dict = {}
    for line in f:
        data = line.split(',')
        dict[data[0]] = map(float, data[1:])
    return dict


def compute_prop_similarity(prop1, prop2):
    """
    calculate similarity between 2 properties
    :param prop1:
    :param prop2:
    :return:
    """
    pid1, pid2 = prop1[0], prop2[0]
    v1, v2 = np.array(prop1), np.array(prop2)
    # unit price as an attribute
    v1[0] = v1[1] / v1[2]
    v2[0] = v2[1] / v2[2]
    # normalization vector
    base = np.array([600, 1000, 2, 1, 600, 0.5, 0.5, 0.5, 0.5, 40.110677, -88.227202])
    divisor = np.array([50, 500, 0.25, 0.5, 300, 0.5, 0.5, 0.5, 0.5, 0.01, 0.01])

    v1 = np.divide(v1 - base, divisor)
    v2 = np.divide(v2 - base, divisor)
    # print 'v1: ', v1
    # print 'v2: ', v2
    similarity = np.dot(v1, v2)
    similarity = similarity / (np.linalg.norm(v1) * np.linalg.norm(v2))
    return similarity


def parse_user(user, major_map, standing_map):
    """
    parse user profile vector into a vector of float
    :param user:
    :param major_map:
    :param standing_map:
    :return:
    """
    username = user[0]
    v = []
    v.append(float(user[2]))
    major = user[3]
    standing = user[4]
    gender = user[5]
    v.append(major_map[major][0])
    v.append(major_map[major][1])
    v.append(standing_map[standing])
    if gender == 'male':
        v.append(1)
    elif gender == 'female':
        v.append(-1)
    else:
        v.append(0)
    return username, np.array(v)


def compute_user_similarity(user1, user2, major_map, standing_map):
    """
    computer similarity of 2 users
    :param user1:
    :param user2:
    :param major_map:
    :param standing_map:
    :return:
    """
    username1, v1 = parse_user(user1, major_map, standing_map)
    username2, v2 = parse_user(user2, major_map, standing_map)
    base = np.array([22, 40.110677, -88.227202, 4.5, 0])
    divisor = np.array([1.5, 0.001, 0.001, 1.5, 0.5])
    v1 = np.divide(v1 - base, divisor)
    v2 = np.divide(v2 - base, divisor)
    # print 'v1: ', v1
    # print 'v2: ', v2
    similarity = np.dot(v1, v2)
    similarity = similarity / (np.linalg.norm(v1) * np.linalg.norm(v2))
    return similarity


def compute_knn_prop(data, num):
    """
    find the k nearest neighbors for each property
    :param data:
    :param num:
    :return:
    """
    knn = {}
    for i in xrange(len(data)):
        for j in xrange(len(data)):
            if i == j: continue
            pid = data[i][0]
            if pid not in knn:
                knn[pid] = []
            similarity = compute_prop_similarity(data[i], data[j])
            if len(knn[pid]) < num:
                heapq.heappush(knn[pid], (similarity, data[j][0]))
            else:
                heapq.heappushpop(knn[pid], (similarity, data[j][0]))
    return knn


def compute_knn_user(data, num):
    """
    find the k nearest neighbors for each user profile
    :param data:
    :param num:
    :return:
    """
    knn = {}
    major_map = read_major_coord()
    standing_map = {'unspecified': 0, 'freshman': 1, 'sophomore': 2, 'junior': 3, 'senior': 4, 'ms': 6, 'phd': 8}
    for i in xrange(len(data)):
        for j in xrange(len(data)):
            if i == j: continue
            username = data[i][0]
            if username not in knn:
                knn[username] = []
            similarity = compute_user_similarity(data[i], data[j], major_map, standing_map)
            if len(knn[username]) < num:
                heapq.heappush(knn[username], (similarity, data[j][0]))
            else:
                heapq.heappushpop(knn[username], (similarity, data[j][0]))
    return knn


def save_to_csv(knn, filename):
    writer = csv.writer(open(filename, 'w+'))
    for pid in knn.keys():
        neighbors = knn[pid]
        for prop in neighbors:
            writer.writerow([pid, prop[1], prop[0]])


prop_data = read_prop_data('property.csv')
knn = compute_knn_prop(prop_data, len(prop_data))
save_to_csv(knn, 'similar.csv')

# user_data = read_user_data('profile.csv')
# knn = compute_knn_user(user_data, len(user_data))
# save_to_csv(knn, 'similar_user.csv')
