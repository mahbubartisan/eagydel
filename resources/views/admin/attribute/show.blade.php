@extends('admin.layouts.app')


@section('content')

<div class="main-content">
    <div class="breadcrumb">
        <h1>Attributes</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
   
    <!-- end of row-->
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <a href="{{ route('create.attribute') }}" class="btn btn-lg btn-outline-success ripple m-3" style="float:right"><i class="fa fa-plus"> Add Attribute</i></a>
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered table-responsive{-sm|-md|-lg|-xl}" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Serial NO.</th>
                                    <th>Attribute Name <sub>(English)</sub></th>
                                    <th>Attribute Name <sub>(Hindi)</sub></th>
                                    <th>Attribute Values <sub>(English)</sub></th>
                                    <th>Attribute Values <sub>(Hindi)</sub></th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                  @forelse ($attr_values as $key =>  $attr_value)
                                {{-- @dd($attr_value) --}}
                                  <tr>
                                  <td>{{ $loop->iteration }}</td>

                                  <td>{{ $attr_value->first()->attributes->attr_name_eng }} </td>
                                  <td>{{ $attr_value->first()->attributes->attr_name_hindi }} </td>
                                  
                                  <td> {{ $attr_value->pluck('attr_value_eng')->implode(',') }}</td>
                                  <td> {{ $attr_value->pluck('attr_value_hindi')->implode(',') }}</td>
                                  <td>
                                    <a href="{{ url('attributes/edit/'.$key) }}" class="btn btn-primary mb-2 ml-3" title="Edit"><i class="nav-icon i-Pen-4"></i></a>
                                    <a href="{{ url('attributes/delete/'.$key) }}" class="btn btn-danger mb-2 ml-3" title="Delete"><i class="na-icon i-Close-Window"></i></a>
                                </td>
                                  

                                @empty
                                    <td>
                                        No records found...
                                    </td>
                                </tr>
                                  @endforelse
                               
                                    
                             
                            </tbody>
                          
                        </table>
                    </div>
                </div>
            </div>
        </div>
     
        <!-- end of col-->
     
    </div>
    <!-- end of row-->
    <!-- end of main-content -->
</div>
    
@endsection