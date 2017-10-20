Magical Tweet Machine
=====================

Utility for breaking up a piece of writing into tweet-sized chunks and scheduling them using Tweetdeck.

Rationale
---------

I built this toolchain for the ShypOfFoles Twitter account. They needed to tweet out quotes from
Barclay's Shyp of Foles on an hourly basis. That's a lot of tweets to schedule! Far too many to
do by hand.

The available APIs were all either (a) expensive or (b) only allowed you to schedule a limited
number of tweets.

So, I built this toolchain. 

How does it work (for artists)
------------------------------

Magic.

How does it work (for programmers)
----------------------------------

1. Create `shyp-trimmed.txt`. Use double line break to separate into stanzas. Each line should be trimmed of whitespace.
2. Run `split.php > schedule.js`. This will give you a randomised schedule.
3. Open Tweetdeck and paste the contents of `tweet.js` into the developer console
4. Paste the contents of `schedule.js` into the developer console
5. Enter `scheduleNextTweet();` into the developer console

At this point, it will go through and schedule all your tweets. It adds a random pause between each one to attempt to fool
firewalls that may otherwise detect you as a robot.

Cautions
--------

I have only tested this with scheduling a limited number of tweets; at some point Twitter/Tweetdeck's firewall may trip and
lock you out. Also, I don't know if Tweetdeck has an API limit.
