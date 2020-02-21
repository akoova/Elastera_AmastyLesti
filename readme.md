![alt text](https://akoova.com/wp-content/uploads/2019/05/logo-retina-reduced.png "Akoova")  
[akoova.com](https://akoova.com) Email: [info@akoova.com](info@akoova.com) Twitter: [@elastera](https://twitter.com/akoova)  

# What is this extension?
Elastera_AmastyLesti is built to solve one specific problem that occurs, 
when using the modules [Amasty Shopby](https://amasty.com) and [Lesti Fpc](https://gordonlesti.com/projects/lestifpc/) together.

# What problem is it solving?
The unwanted behavior is that Lesti is caching the category page always the same.
Selecting a filter will not do anything. When we activate ajax in the Amasty Shopby configuration,
we see that there is a call to the category site with the get parameter `is_ajax`
So we can make add the `is_ajax` to the "Miss Uri Params", and the filters seem to work again.  

But there are still 3 problems left:

* the first call to the category will generate tha cache.  
That means, when a customer selects a filter, during a fpc purge,
this customer will cause the generation of the category page with his active filters.  
All other customers requesting the category will get exactly that filters pre-selected.
* the preselected filters are active on all pages, if we disable javascript in the browser!
* the is_ajax is causing a cache miss. That means the result will be rendered on all requests. FPC is disabled here.

What we want is:

* FPC should cache all categories.
* FPC should consider the filters
* FPC should consider if ajax is used, or not.

# How it works / What does this extension do?
To get this working, Elastera_AmastyLesti simply uses the Amasty Shopby active filters,
and adds them as cache keys in Lesti FPC.  
That is done via an observer on `fpc_helper_collect_params`.  
Here we ask Amasty Shopby, if it has selected filters. And if there are any, we add them to the cache keys.
That works for the page requests, as well as for the ajax requests.  
If ajax is active in Amasty Shopby, we need to put the get parameter `is_ajax` to the "Uri Params" in Lesti.

# Requirements

* Amasty Shopby Improved Navigation is used
* Lesti FPC is used
* If using ajax in Amasty Shopby, we need to configure `is_ajax` to the "Uri Params" in Lesti.

# Install
To install the extension with [modman](https://github.com/colinmollenhour/modman) get the extension using  
`git clone git@github.org:elastera/Elastera_AmastyLesti.git`  
Then execute `modman link ../vendor/elastera/Elastera_AmastyLesti`
(Change the path to the location of the git clone result)

In System -> Advanced -> System -> Lesti FPC -> Uri Params add the value `is_ajax`  
