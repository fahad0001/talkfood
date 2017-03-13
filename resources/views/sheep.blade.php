<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SheepIt! Jquery Form Cloning Plugin - Example 3</title>
<!-- <script type="text/javascript" src="jquery-1.4.4.min.js"></script> -->
<!-- <script type="text/javascript" src="jquery-1.4.3.min.js"></script> -->
<!-- <script type="text/javascript" src="jquery-1.4.2.min.js"></script> -->
<!-- <script type="text/javascript" src="jquery-1.4.1.min.js"></script> -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="{{URL::asset('/js/jquery.sheepItPlugin.js')}}"></script>
    <script>var $j = jQuery.noConflict(true);</script>
    <script>
      $(document).ready(function(){
       console.log($().jquery); // This prints v1.4.2
       console.log($j().jquery); // This prints v1.9.1
      });
   </script>
<script src="{{URL::asset('/js/jquery.sheepItPlugin.js')}}"></script>
<script type="text/javascript">

$(document).ready(function() {
    
    
     var addressesForm = $j("#person_addresses").sheepIt({
        separator: '',
        allowRemoveLast: true,
        allowRemoveCurrent: true,
        allowRemoveAll: true,
        allowAdd: true,
        allowAddN: true,
        
        // Limits
        maxFormsCount: 10,
        minFormsCount: 0,
        iniFormsCount: 1,
        nestedForms: [
            {
                id: 'person_addresses_#index#_phones',
                options: { 
                     indexFormat: '#index_phones#',
                     maxFormsCount: 5
                }
            }
        ]
        
    });
     
    
});

</script>


<style>

a {
    text-decoration:underline;
    color:#00F;
    cursor:pointer;
}

.controls div, .controls div input {
    float:left;    
    margin-right: 10px;
}

</style>

</head>

<body>

    <!-- Main sheepIt Form -->
    <label>Addresses</label>
    
    
    <div id="person_addresses" name="person_addresses">
    
        <!-- Form template-->
        <div id="person_addresses_template">
            <label for="person_addresses_#index#_address">Address <span id="person_addresses_label"></span></label>
            <input id="person_addresses_#index#_address" name="person[addresses][#index#][address]" type="text" size="50" maxlength="100" />
            <a id="person_addresses_remove_current"><img src="images/cross.png" width="16" height="16" border="0"></a>
            
            <!-- Embeded sheepIt Form -->
            <div style="margin-left:50px; overflow:hidden;">
                <label>Phones</label>
                
                <div id="person_addresses_#index#_phones" name="person_addresses_#index#_phones">
                
                    <!-- Nested form template-->
                    <div id="person_addresses_#index#_phones_template">
                        <label for="person_addresses_#index#_phones_#index_phones#_phone">Phone <span id="person_addresses_#index#_phones_label"></span></label>
                        <input id="person_addresses_#index#_phones_#index_phones#_phone" name="person[addresses][#index#][phones][#index_phones#][phone]" type="text" size="15" maxlength="10" />
                        <a id="person_addresses_#index#_phones_remove_current"><img src="images/cross.png" width="16" height="16" border="0"></a>
                    </div>
                    <!-- /Nested form template-->
                    
                    <!-- No forms template -->
                    <div id="person_addresses_#index#_phones_noforms_template">No phones</div>
                    <!-- /No forms template-->
                    
                    <!-- Controls -->
                    <div id="person_addresses_#index#_phones_controls" class="controls">
                        <div id="person_addresses_#index#_phones_add"><a><span>Add phone</span></a></div>
                        <div id="person_addresses_#index#_phones_remove_last"><a><span>Remove</span></a></div>
                        <div id="person_addresses_#index#_phones_remove_all"><a><span>Remove all</span></a></div>
                        <div id="person_addresses_#index#_phones_add_n">
                            <input id="person_addresses_#index#_phones_add_n_input" type="text" size="4" />
                            <div id="person_addresses_#index#_phones_add_n_button"><a><span>Add</span></a></div>
                        </div>
                    </div>
                    <!-- /Controls -->
                    
                </div>
                
            </div>
            <!-- /Embeded sheepIt Form -->
            
        </div>
        <!-- /Form template -->
        
        <!-- No forms template -->
        <div id="person_addresses_noforms_template">No addresses</div>
        <!-- /No forms template -->
        
        <!-- Controls -->
        <div id="person_addresses_controls" class="controls">
            <div id="person_addresses_add"><a><span>Add address</span></a></div>
            <div id="person_addresses_remove_last"><a><span>Remove</span></a></div>
            <div id="person_addresses_remove_all"><a><span>Remove all</span></a></div>
            <div id="person_addresses_add_n">
                <input id="person_addresses_add_n_input" type="text" size="4" />
                <div id="person_addresses_add_n_button"><a><span>Add</span></a></div>
            </div>
        </div>
        <!-- /Controls -->
        
    </div>
    <!-- /Main sheepIt Form -->


</body>
</html>
