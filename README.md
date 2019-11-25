# Solving my iPresence Tech Test 

## Solution (original brief below) 

Configuration is done by the config file: 
```
config/conf.ini
```
Its parameters are:
```
data_file_name ... file name of the JSON data-file located in the root directory, including suffix
max_returned_qotes ... integer value of maximum possible returned quotes per request
base_uri ... base URI for the application, used in the unit-tests
randomized_result ... yes/no ... if results should be randomized

redis_scheme ... predis scheme settings
redis_host ... predis host
redis_port ... predis port

message_method_not_allowed ... message shown if request method not allowed
message_not_found ... message shown if author not found
message_data_error ... message shown if data-file not found
message_bad_request_author_name ... message shown if author's name contains not allowed characters
message_bad_request_larger_limit ...  message shown if limit is set larger than allowed
```
## Runnin tests

All tests are located in the /tests directory

Running tests:
```
./vendor/bin/phpunit tests/
```

## Other than REST API usage

You just need to bypass API layer (ApiRequest) and work directly with QuotesFeed class.


## ORIGINAL BRIEF:


We want you to implement a REST API that, given a famous person and a count N, returns N quotes from this famous person _shouted_ .

Shouting a quote consists of transforming it to uppercase and adding an exclamation mark at the end. 

Our application could have multiple sources to get the quotes from, for example an REST API like https://theysaidso.com/api/ could be used, 
although for the sake of the test we provided a sample of quotes by famous persons that can be used, so no need to perform real calls to our source API

We also want to get a cache layer of these quotes in order to avoid hitting our source (which let's imagine is very expensive) twice for the same person given a T time.

## Example 

Given these quotes from Steve Jobs:
- "The only way to do great work is to love what you do.",
- "Your time is limited, so don’t waste it living someone else’s life!"

The returned response should be:
```
curl -s http://awesomequotesapi.com/shout/steve-jobs?limit=2
[
    "THE ONLY WAY TO DO GREAT WORK IS TO LOVE WHAT YOU DO!",
    "YOUR TIME IS LIMITED, SO DON’T WASTE IT LIVING SOMEONE ELSE’S LIFE!"
]
```

## Constraints 
- Count N provided MUST be equal or less than 10. If not, our API should return an error.

## What will we evaluate?
* **Design**: We know this is a very simple application but we want to see how you design code. We value having a clear application architecture, that helps maintain it (and make changes requested by the product owner) for years.
* **Testing**: We love automated testing and we love reliable tests. We like testing for two reasons: First, good tests let us deploy to production without fear (even on a Friday!). Second, tests give a fast feedback cycle so developers in dev phase know if their changes are breaking anything.
* **Simplicity**: If our product owner asks us for the same application but accessed by command line (instead of the http server) it should be super easy to bring to life!
