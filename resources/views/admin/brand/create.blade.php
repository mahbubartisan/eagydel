@extends('admin.layouts.app')


@section('content')

<div class="main-content">
    <div class="breadcrumb">
        <h1>Create a new brand</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <section class="widget-card">
        <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-xl-4 mt-3">
                
                    <h5 class="ul-widget-card__title"><span class="t-font-boldest">Brand Image</span></h5>
                    <p class="card-text"><span class="t-font-bold">Upload your brand image from here.</span></p>
            
                </div>
            <div class="col-lg-8 col-xl-8 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="picker1">Image</label>
                                    <input type="file" class="form-control" name="brand_image" onchange="preview()">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <img src="{{ asset('ecommerce/no-image.png') }}" alt="image" id="showImage" 
                                    style="wight:70px; height:70px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card End -->
            </div>

            <div class="col-lg-4 col-xl-4 mt-3">
                
                <h5 class="ul-widget-card__title"><span class="t-font-boldest">Description</span></h5>
                <p class="card-text"><span class="t-font-bold">Write your brand description from here.</span></p>
        
            </div>
        <div class="col-lg-8 col-xl-8 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="picker1">Name <sub>(English)</sub></label>
                                <input type="text" class="form-control" name="brand_name_eng">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="picker1">Name <sub>(Hindi)</sub></label>
                                <input type="text" class="form-control" name="brand_name_hindi">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="picker1">Types</label>
                                <select class="form-control" name="type_id">
                                    <option selected disabled>Select type</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_eng }}</option>
                                    @endforeach
                                </select>
                        </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Card End -->
            <div class="mt-3 mb-5">
                <input type="submit" style="float:right" class="btn btn-lg btn-primary" value="Add Brand">
            </div>
        </div>
        </form>
    </section>
    </div><!-- end of main-content -->
</div>
@endsection