import csv
import hashlib
import math


def gen_username(num):
    """
    generate a large number of default usernames that are assumed in the database
    :param num:
    :return:
    """
    writer = csv.writer(open('username.csv', 'w+'))
    for i in xrange(num):
        # print format(i, '08d')
        writer.writerow([format(i, '07d')])


def read_data(filename):
    """
    read the existing usernames in the database
    :param filename:
    :return:
    """
    usernames = []
    f = open(filename, 'r')
    for line in f:
        usernames.append(line.strip())
    return usernames


def create_bloom_filter(capacity, error):
    """
    build a bloom filter
    choose parameters based on given capacity and error rate
    :param capacity:
    :param error:
    :return:
    """
    k = math.log(1 / error, 2)
    bf = [0] * capacity * int(math.ceil(k / math.log(2)))
    usernames = read_data('username.csv')
    for username in usernames:
        add(bf, error, username)
    return bf


def save_to_file(bf, error_rate):
    """
    save bloom filter to csv file
    id = -1: bloom filter's capacity
    id = -2: bloom filter's error rate
    :param bf:
    :return:
    """
    num = 1
    for j in xrange(num):
        # writer = csv.writer(open('bloom_filter_' + str(j) + '.csv', 'w+'))
        writer = csv.writer(open('bloom_filter.csv', 'w+'))
        if j == 0:
            writer.writerow([-1, len(bf)])
            writer.writerow([-2, int(1 / error_rate)])
        for i in range(j*len(bf)/num, (j+1)*len(bf)/num):
            writer.writerow([i + 1, bf[i]])


def add(bf, error, username):
    """
    add one username to the bloom filter (with given error rate)
    :param bf:
    :param error:
    :param username:
    :return:
    """
    k = math.log(1 / error, 2)
    for i in xrange(int(math.ceil(k))):
        h = hashlib.sha256()
        h.update(username)
        h.update(hex(i))
        bf[int(h.hexdigest(), 16) % len(bf)] += 1


def add_user_profile(bf, error):
    """
    add usernames from registered user profile to the bloom filter
    :param bf:
    :param error:
    :return:
    """
    f = open('profile.csv', 'r')
    usernames = []
    for line in f:
        usernames.append(line.split(',')[0])
    # print usernames
    for username in usernames:
        add(bf, error, username)
    return bf


def load_bf():
    """
    load saved bloom filter to memory for use
    :return:
    """
    f = open('bloom_filter.csv', 'r')
    bf = []
    length = int(f.readline().strip().split(',')[1])
    error_rate = 1.0 / float(f.readline().strip().split(',')[1])
    for line in f:
        bf.append(int(line.strip().split(',')[1]))
    return bf, length, error_rate


def test_in(bf, error, username):
    k = math.log(1 / error, 2)
    for i in xrange(int(math.ceil(k))):
        h = hashlib.sha256()
        h.update(username)
        h.update(hex(i))
        if bf[int(h.hexdigest(), 16) % len(bf)] == 0:
            return False
    return True


def benchmark(bf, error_rate, num):
    count, false_pos = 0, 0.0
    while count < num:
        count += 1
        s = 'abcdefg' + str(count)
        if (test_in(bf, error_rate, s)):
            false_pos += 1.0
    return false_pos / num


username_num = 10**6
error_rate = 0.001
gen_username(username_num)
print 'finish generation'
bf = create_bloom_filter(username_num, error_rate)
print 'finish creating'
bf = add_user_profile(bf, error_rate)
save_to_file(bf, error_rate)
print 'finish saving'

bf, length, error_rate = load_bf()
print length, error_rate

print test_in(bf, error_rate, 'Alice1995')
print test_in(bf, error_rate, 'blabla')

print benchmark(bf, error_rate, 10 ** 6)


# username_num = 10**2
# error_rate = 0.01
# gen_username(username_num)
# bf = create_bloom_filter(username_num, error_rate)
# bf = add_user_profile(bf, error_rate)
# save_to_file(bf, error_rate)
