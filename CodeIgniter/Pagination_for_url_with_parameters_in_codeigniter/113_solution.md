Some problems when having optional parameters along with pagination:

The placement of pagination offset changes in the URL based on the number of provided parameters.
If optional parameters are not set, the pagination offset will act as a parameter.
Method 1:
Use query strings for pagination:

```
function student($gender, $category = NULL) {
    $this->load->library('pagination');
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'offset';

    $config['base_url'] = base_url().'test/student/'.$gender;
    // add the category if it's set
    if (!is_null($category)) 
        $config['base_url'] = $config['base_url'].'/'.$category;

    // make segment based URL ready to add query strings
    // pagination library does not care if a ? is available
    $config['base_url'] = $config['base_url'].'/?';


    $config['total_rows'] = 200;
    $config['per_page'] = 20;
    $this->pagination->initialize($config);

    // requested page:
    $offset = $this->input->get('offset');

    //...
}
```

Method 2:
Assuming the category would never be a number and if the last segment is a numeric value then it's the pagination offset not a function's parameter:

```
function student($gender, $category = NULL) {
    // if the 4th segment is a number assume it as pagination rather than a category
    if (is_numeric($this->uri->segment(4))) 
        $category = NULL;

    $this->load->library('pagination');
    $config['base_url'] = base_url().'test/student/'.$gender;
    $config['uri_segment'] = 4;

    // add the category if it's set
    if (!is_null($category)) {
        $config['uri_segment'] = $config['uri_segment'] + 1;
        $config['base_url'] = $config['base_url'].'/'.$category;
    }

    $config['total_rows'] = 200;
    $config['per_page'] = 20;
    $this->pagination->initialize($config);

    // requested page:
    $offset = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 1;

    //...
}   
```

I prefer the first method because it does not interfere with function parameters and it would be easier to implement the pagination support at an abstract level.