@extends('layouts.admin')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{__('admin/sidebar.Main')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a href="">{{__('admin/sidebar.Sections')}} </a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin/sidebar.AddNewSection')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> {{__('admin/sidebar.AddNewSection')}}</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{route('admin.Categories.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label> {{__('admin/Category.photo')}} </label>
                                                <label for="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="photo">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('photo')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> {{__('admin/Category.SectionInfo')}}</h4>


                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> {{__('admin/Category.SectionName')}}</label>
                                                                    <input type="text" id="name"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           value="{{old('name')}}"
                                                                           name="name">
                                                                    @error("name")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> {{__('admin/Category.Slug')}}</label>
                                                                    <input type="text" id="abbr"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           value="{{old('slug')}}"
                                                                           name="slug">

                                                                    @error("slug")
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                        </div>

                                                <div  class="row hidden " id="cats_list">
                                                        <div class="col-md-12 ">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> {{__('admin/Category.ChooseCat')}} </label>
                                                                <select name = "parent_id" style ="width:auto;" class = "form-control">
                                                                    <optgroup label="من فضلك ادخل القسم">
                                                                        @if($categories && $categories->count()>0)
                                                                            @foreach($categories as $category)
                                                                                <option
                                                                                    value= "{{$category->id}}">{{$category-> name}}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </optgroup>
                                                                </select>
                                                                @error('parent_id')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <input type="checkbox" value="1"
                                                                           name="is_active"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                            checked />
                                                                    <label for="switcheryColor4"
                                                                           class="card-title ml-1">{{__('admin/brand.status')}} </label>

                                                                    @error("is_active")
                                                                    <span class="text-danger"> {{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="radio"
                                                                           name ="type" value = "1"  checked class ="Switchery"  style="height:23px; width:23px;" data-color ="success" >

                                                                    <label class ="card-title-m1" style ="size: 40px; vertical-align: top">
                                                                        {{__('admin/Category.MainCategory')}}
                                                                    </label>

                                                                </div>
                                                            </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="radio"
                                                                               name ="type" value="2"  style="height:23px; width:23px;" class ="Switchery" data-color ="success">

                                                                        <label class ="card-title-m1" style ="size: 40px; vertical-align: top">

                                                                            {{__('admin/Category.SubCategory')}}
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                        </div>


                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('admin/edit.Back')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{__('admin/edit.Save')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('input:radio[name="type"]').change(
            function()
            {
                if(this.checked && this.value == '2')
                {
                    $('#cats_list').removeClass('hidden');
                }
                else{
                    $('#cats_list').addClass('hidden');
                }
            }
        );
    </script>

    @endsection
