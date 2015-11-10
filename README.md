Attribute Free Form
===================

A concrete5.7 attribute you can use to quickly create your own attribute types.

When you add a free form attribute, you've got two fields, one where you specify the form you'll see when you enter some data and a view form you'll see when the data
 is presented to the end-user.
 
In order to to save and load fields you have to use specific names which will be replaced at runtime.

Example 1 - Simple field
------------------------
edit form:
```html
<strong>Name:</strong>
<input type="text" name="[ATTRIBUTE(Name)]" value="[ATTRIBUTE_VALUE(Name)]">
```

view:
```html
<strong>Name:</strong>
[ATTRIBUTE_VALUE(Name)]
```

Example 2 - Hidden fields with JavaScript
-----------------------------------------
edit form:
```html
<input type="hidden" name="[ATTRIBUTE(Lat)]" value="[ATTRIBUTE_VALUE(Lat)]" id="lat"><br>
<input type="hidden" name="[ATTRIBUTE(Long)]" value="[ATTRIBUTE_VALUE(Long)]" id="long"><br>

<div>
    Address: <input type="text" name="[ATTRIBUTE(Address)]" value="[ATTRIBUTE_VALUE(Address)]" id="address"><br>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#address").on("change", function() {
            var address = $(this).val();
            $.ajax({
                url:"http://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false",
                type: "POST",
                success:function(res){
                    lat = res.results[0].geometry.location.lat;
                    long = res.results[0].geometry.location.lng;
                    $("#lat").val(lat);
                    $("#long").val(long);
                }
            }); 
        });
    })
</script>
```

view:
```html
<div>
    <strong>Address</strong>[ATTRIBUTE_VALUE(Address)] ([ATTRIBUTE_VALUE(Lat)] / [ATTRIBUTE_VALUE(Long)])
</div>
```

Example 3 - Access fields programmatically
------------------------------------------

Assuming you've got the form in place from the first example using an attribute handle of `test_attribute`.
If you want to work with the attribute fields from a custom theme or another concrete5 method, you can use the
following approach.

```php
// get the page we want to work with
$p = \Page::getByID(1);

// show attribute view
echo $p->getAttribute('test_attribute');

// get value of our attribute field called "Name"
$values = $p->getAttribute('test_attribute', 'variables');
echo $values['Name'];
```