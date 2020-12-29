# Storykube PHP Summariser
**Fork from https://github.com/PHP-Science/TextRank**. 

This source code is an implementation of the TextRank algorithm (Automatic summarization). \
It can summarize a text, article for example to a short paragraph. Before it would start the summarizing it removes the junk words what are defined in the Stopwords namespace. It is possible to extend it with another languages.

Many thanks to @DavidBelicza and all contributors for made a very interesting package [PHP-Science/TextRank](https://github.com/PHP-Science/TextRank), from which Storykube generated its fork.

## Run tests
```bash
composer install --dev
composer test
```