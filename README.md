# Andersen coding test

## Description
We have a text file with structured tree information in form of:
node_id|parent_id|node_name
node_id: numeric node id
parent_id: id of parent node

Main task is to represent this tree with correct paddings for every level,
level one - zero paddings, level two - one padding and so on.

Try to write code as simple as possible and we want to see high performance solution
---------------------------------------------------------------------------
Input data:

1|0|Electronics

2|0|Video

3|0|Photo

4|1|MP3 player

5|1|TV

6|4|iPod

7|6|Shuffle

8|3|SLR

9|8|DSLR

10|9|Nikon

11|9|Canon

12|11|20D


---------------------------------------------------------------------

Output data:

Electronics

-MP3 player

--iPod

---Shuffle

-TV

Video

Photo

-SLR

--DSLR

---Nikon

---Canon

----20D


## How to install

1. Clone this repository and navigate to the project folder.
2. Use Composer to resolve all dependencies - run `composer install`.
2. You must have apache/php-fpm installed and tuned.
3. Open the application in your browser.