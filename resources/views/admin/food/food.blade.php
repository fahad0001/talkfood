@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection


@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Menu Item</h3>
            </div>
            <form class="form-horizontal" role="form" action="{{URL::to('admin/addmenuitem')}}" method="POST">
                {{Csrf_field()}}
                <div class="box-body">
                    <div class="form-group">
                        <label for="DishType" class="col-md-3 control-label">Category:</label>
                        <div class="col-md-6">
                            <select name="categ_id" class="form-control">
                                @foreach($categs as $categ)
                                <option value="{{ $categ->cate_id }}" > {{ $categ->cate_name }}</option>
                                @endforeach
                            </select>

                        </div>


                    </div>
                    <div class="form-group">
                        <label for="DishType" class="col-md-3 control-label">Item Name:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="typename" name="food" placeholder="" required="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Description:</label>
                        <div class="col-md-6">
                            <textarea type="textarea" class="form-control" id="typename" name="description"></textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Price:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="typename" name="price" placeholder="" >

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Options:

                        </label>
                        <div class="col-md-9" style="    padding-top: 8px;">



                            <!-- Main sheepIt Form -->
                           


                            <div id="person_addresses">

                                <!-- Form template-->
                                <div id="person_addresses_template" style="padding: 10px; margin-top:5px;
    border: 1px solid black;">
                                     
                                    <input id="person_addresses_#index#_address" name="option[#index#][name]" type="text" placeholder="Option Name" />
                                    
                                    
                                   <select id="person_addresses_#index#_type" name="option[#index#][type]" type="text" >
                                      <option value='Dropdown'>Dropdown</option>
                    <option value='Checkbox'>Checkbox</option>
                    
                                    </select>    
                                    <a id="person_addresses_remove_current">Remove</a>
                                   
                                    <!-- Embeded sheepIt Form -->
                                    <div style="margin-left:50px; overflow:hidden;">
                                        <label>Sub Option</label>

                                        <div id="person_addresses_#index#_phones">

                                            <!-- Nested form template-->
                                            <div id="person_addresses_#index#_phones_template">
                                               
                                                <input id="person_addresses_#index#_phones_#index_phones#_phone" name="option[#index#][subopt][#index_phones#][name]" type="text"  placeholder="Sub Option Name" />
                                                
                                                
                                                <input id="person_addresses_#index#_phones_#index_phones#_price" name="option[#index#][subopt][#index_phones#][price]" type="text" placeholder="Sub Option Price" />
                                                <a id="person_addresses_#index#_phones_remove_current">remove</a>
                                               
                                                </div>
                                            <!-- /Nested form template-->

                                            <!-- No forms template -->
                                            <div id="person_addresses_#index#_phones_noforms_template">No Suboptions</div>
                                            <!-- /No forms template-->

                                            <!-- Controls -->
                                            <div id="person_addresses_#index#_phones_controls" class="controls" style="margin-top:5px;">
                                                <div id="person_addresses_#index#_phones_add"><a Class="btn btn-primary btn-sm"><span>Add Sub Option</span></a></div>
                                                <div id="person_addresses_#index#_phones_remove_last" ><a Class="btn btn-primary btn-sm" style="margin-top:5px"><span>Remove</span></a></div>
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
                                <div id="person_addresses_noforms_template">No Option</div>
                                <!-- /No forms template -->

                                <!-- Controls -->
                                <div id="person_addresses_controls" class="controls"  style="margin-top:5px;">
                                    <div id="person_addresses_add"><a Class="btn btn-primary btn-sm" ><span>Add Option</span></a></div>
                                    <div id="person_addresses_remove_last"><a Class="btn btn-primary btn-sm" style="margin-top:5px;"><span>Remove</span></a></div>
                                    <div id="person_addresses_remove_all"><a><span>Remove all</span></a></div>
                                    <div id="person_addresses_add_n">
                                        <input id="person_addresses_add_n_input" type="text" size="4" />
                                        <div id="person_addresses_add_n_button"><a><span>Add</span></a></div>
                                    </div>
                                </div>
                                <!-- /Controls -->

                            </div>
                            <!-- /Main sheepIt Form -->


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">            
                                    <button type="submit" class="btn btn-google">Submit</button>            
                                </div>
                            </div>
                            <div class="box-body">


                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <!--
            Detail of the name used in the script
            name for options:
            email: menuoptionemail<incvalue>
            description: menuoptiondesc<incvalue>
            price: menuoption<incvalue>
            -->

            @endsection

            @section('scripts')
            <script type="text/javascript">

                $(document).ready(function () {


                    var addressesForm = $j("#person_addresses").sheepIt({
                        separator: '',
                        allowRemoveLast: true,
                        allowRemoveCurrent: true,
                        allowRemoveAll: false,
                        allowAdd: true,
                        allowAddN: false,
                        // Limits
                      
                        minFormsCount: 0,
                        iniFormsCount: 0,
                        nestedForms: [
                            {
                                id: 'person_addresses_#index#_phones',
                                options: {
                                    indexFormat: '#index_phones#',
                                    
                                     minFormsCount: 0,
                                    iniFormsCount: 0,
                                }
                            }
                        ]

                    });

                });

            </script>
            @endsection

