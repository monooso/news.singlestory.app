# Contributing
Single Story is deliberately simple.

If you find a bug, please feel free to submit a pull request (following the guidelines in this document).

If you have a grand idea for some new Single Story feature, please open an issue first, so we can have a chat about whether it's a good fit; I wouldn't want you to waste your time building something which I then reject.
 
Of course, you can always fork the project, if you'd like to take it in a different direction.

## Standard process ##

Fork, then clone the repo:

    git clone git@github.com:your-username/news.singlestory.app.git

Make sure the tests pass:

    phpunit --testsuite=internal

Make your change, including tests, and make sure all the tests still pass:

    phpunit --testsuite=internal

Push to your fork and [submit a pull request][pr].

[pr]: https://github.com/monooso/news.singlestory.app/compare/

At this point you're waiting on me.
 
I'll do my best to respond within 3 business days. I may suggest some changes, or an alternative approach, or I may just have some questions.

Here are some things that will increase the chance of me accepting your pull request:

- Write tests.
- Follow the existing code style (I don't have a formal style guide at present, but stick with [PSR-2][psr-2], and you won't go far wrong).
- Write a [good commit message][commit].

[psr-2]: http://www.php-fig.org/psr/psr-2/
[commit]: http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html
