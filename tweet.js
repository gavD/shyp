/**
 * Code that can be loaded into the developer console on Tweetdeck to allow programatic scheduling of
 * tweets
 *
 * Once you've loaded this, you can paste in the output of split.php
 */

// A list of tweets. Gets build in scheduleTweet()
var tweetList = [];
// The counter of the tweet being scheduled
var tweetIndex = -1;

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/**
 * adds a tweet to the tweetList. Always works against the current month at the time of writing.
 * @param {string} text The text of the tweet to schedule.
 * @param {number} hr Hour of the day to schedule this tweet for.
 * @param {number} dayofmonth Day of the month, e.g. 25 for the 25th
 */
function scheduleTweet(text, hr, dayofmonth) {
    tweetList.push(function() {
        $('.compose-text').val(text);
        $('.js-schedule-button').click();
        $('#scheduled-hour').val(hr);
        $('#scheduled-minute').val('00');

        // click today's date
        $('#calweeks .calweek a').filter( function (index) {
            return $(this).text() == dayofmonth;
        }).click();

        // trigger the change event
        $('.compose-text').trigger(jQuery.Event('change', {}));

        // submit the event
        $('.js-send-button').click();
    });
}

/**
 * Run this function to start scheduling the chain.
 *
 * It will take a max of 4 seconds per tweet to run.
 *
 * When it's finished, you'll see "All done!" on the console.
 */
function scheduleNextTweet() {
    tweetIndex++;
    console.log(`Schedule tweet ${tweetIndex}`);
    tweetList[tweetIndex]();

    if (tweetList[tweetIndex + 1]) {
        console.log("Waiting a bit...");
        setTimeout(scheduleNextTweet, getRandomInt(1500, 4000));
    } else {
        console.log("All done!");
    }
}
