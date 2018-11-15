JsonApiErrorResponseBundle
==========================
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/faecie/json-api-error-response/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/faecie/json-api-error-response/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/faecie/json-api-error-response/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/faecie/json-api-error-response/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/faecie/json-api-error-response/badges/build.png?b=master)](https://scrutinizer-ci.com/g/faecie/json-api-error-response/build-status/master)
[![License](https://poser.pugx.org/faecie/json-api-error-response/license)](https://packagist.org/packages/faecie/json-api-error-response)

____________________________

This bundle provides a way return [JSON:API](https://jsonapi.org/format/#errors) compatible error responses from REST endponts

Perfectly works along with FOS REST bundle configured to json response. OIn this case you will alway get response in a JSONAPI compatible format. https://jsonapi.org/format/#errors

# Installation

```console
$ composer require composer require faecie/json-api-error-response ^0.1.4
```
# Configuration
You can configure the response of your exception in different ways:
 1. Implement interface `DescriptiveExceptionInterface` on your  ezxception with only one method returning the array of Error objects
 2. Configure each exception class in the bandle configuration
 3. Tag you service as `json_api.exception_describer` and implement `ExceptionDescriberInterface` on it with only one method allowing you to control how to serialize your exceptions 
