# SWH API Client

This is a PHP API client/connector for [Software Heritage (SWH) web API](https://archive.softwareheritage.org/api/) - currently in Beta phase. The client is wrapped round the [`Illuminate Http package`](https://packagist.org/packages/illuminate/http) and the [`GuzzleHTTP`](https://docs.guzzlephp.org/en/stable/index.html) library.

**Detailed documentation** can be found in the [wiki pages](https://github.com/Ramy-Badr-Ahmed/swh-client/wiki) of this very repository. Working on new features and fixes are gladly considered.

## Installation Steps:

    1) Clone this project.
    
    2) Open a console session and navigate to the cloned directory:
    
        Run "composer install"

        This should involve installing the PHP REPL, PsySH

    3) (Optional) Acquire SWH tokens for increased SWH-API Rate-Limits.
    
    4) Prepare .env file and add tokens:   
    
        4.1) Rename/Copy the cloned ".env.example" file to .env
                cp .env.example .env   
                
        4.2) (Optional) Edit these two token keys:
        
                SWH_TOKEN=Your_TOKEN_FROM_SWH_ACCOUNT                   # step 3)                 
                SWH_TOKEN_STAGING=Your_STAGING_TOKEN_FROM_SWH_ACCOUNT   # step 3)                 

    5) (optional) Add psysh to PATH.

## Usage:

In a console session inside the cloned directory, start the php REPL:

```php
$ psysh     // if not added to PATH replace with: vendor/bin/psysh

Psy Shell v0.12.0 (PHP 8.2.0 — cli) by Justin Hileman
```

This will open a REPL console-based session where one can test the functionality of the api classes and their methods before building a suitable workflow/use-cases.

### Presets

As a one-time configuration parameter, you can set the desired returned data type by SWH (default JSON):

```php
> namespace Module\HTTPConnector;
> use Module\HTTPConnector;         

> HTTPClient::setOptions(responseType:'object')     // json/collect/object available
```

### Visits

Retrieve Latest Full Visit in the SWH archive:

```php
> namespace Module\OriginVisits;
> use Module\OriginVisits; 

> $visitObject = new SwhVisits('https://github.com/torvalds/linux/');

> $visitObject->getVisit('latest', requireSnapshot: true)
```

### DAG Model:

As graph Nodes, retrieve node Contents, Edges or find a Path to other nodes (top-bottom):

```php
> namespace Module\DAGModel;
> use Module\DAGModel; 

> $snpNode = new GraphNode('swh:1:snp:bcfd516ef0e188d20056c77b8577577ac3ca6e58')

> $snpNode->nodeHopp()   // node contents

> $snpNode->nodeEdges()  // node edges keyed by the respective name

> $revNode = new GraphNode('swh:1:rev:9cf5bf02b583b93aa0d149cac1aa06ee4a4f655c')

> $revNode->nodeTraversal('deps/nghttp2/lib/includes/nghttp2/nghttp2ver.h.in') //  traverse to a deeply nested file
```

### Archive

You can specify repositories URL w/o paths and archive to SWH using one of the two variants (`static/non-static methods`):

```php
> namespace Module\Archival;
> use Module\Archival; 
    
> $saveRequest = new Archive('https://github.com/torvalds/linux/')    // Example 1
> $saveRequest->save2Swh()
    
> $newSaveRequest = Archive::repository('https://github.com/hylang/hy/tree/stable/hy/core')  // Example 2

    // in both cases: the returned POST response contains the save request id and date
```

Enquire about archival status using the id/date of the archival request (available in the initial POST response)

```php
> $saveRequest->getArchivalStatus($saveRequestDateOrID)     // current status is returned 
> $saveRequest->trackArchivalStatus($saveRequestDateOrID)   // tracks until archival has succeeded
```

### MetaData

Returns a list of metadata authorities that provided metadata on the given target

```php
> namespace Module\MetaData;
> use Module\MetaData; 

> SwhMetaData::getOriginMetaData('https://github.com/torvalds/linux/')
```