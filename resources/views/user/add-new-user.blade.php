@extends('layouts.star-admin-app')
@section('css')
<style>
    .input-group-text {
    line-height: 0.9 !important;
}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{$title}}</h4>
            <p class="card-description">
                {{$label}}
            </p>
            <label for="firstname">INSTRUCTION: Please fillout the field with (<span style="color:red"> * </span>).</label><br><br>
            <form class="forms-sample" id="add_new_user_form" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="firstname">Fist Name <span style="color:red"> * </span></label>
                            <input type="text" class="form-control " id="firstname" name="firstname" placeholder="First Name">
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lastname">Last Name <span style="color:red"> * </span></label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="middlename">Middle Name <span style="color:red"> * </span></label>
                            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="suffix">Suffix <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" data-live-search="true" name="suffix"
                                id="suffix">
                                <option value="" disabled="" selected="">Select...</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="JR">JR</option>
                                <option value="SR">SR</option>
                                <option value="NA">NA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth <span style="color:red"> * </span></label>
                            {{-- <input type="text" class="form-control" id="date_of_birth"/> --}}

                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span> </span>
                                </div>
                                <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth">
                              </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sex">Sex <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" data-live-search="true" name="sex"
                                id="sex">
                                <option value="" disabled="" selected="">Select...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="civil_status">Civil Status <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" data-live-search="true" name="civil_status"
                                id="civil_status">
                                <option value="" disabled="" selected="">Select...</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Separated">Separated</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="religion">Religion <span style="color:red"> * </span></label>
                            <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Region <span style="color:red"> * </span></label>
                            <select class="form-control" data-live-search="true" id="region" name="region">
                                <option value="" disabled selected>Select.....</option>
                            </select>
                        </div>
                    </div>
                    <!-- Province -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Province <span style="color:red"> * </span></label>
                            <select class="form-control" data-live-search="true" id="province" name="province">
                                <option value="" disabled selected>Select.....</option>
                            </select>
                        </div>
                    </div>

                    <!-- City -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>City <span style="color:red"> * </span></label>
                            <select class="form-control" data-live-search="true" id="city" name="city">
                                <option value="" disabled selected>Select.....</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Barangay -->
                        <div class="form-group">
                            <label>Barangay <span style="color:red"> * </span></label>
                            <select class="form-control" data-live-search="true" id="barangay" name="barangay">
                                <option value="" disabled selected>Select.....</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="home_address">Home Adrress <span style="color:red"> * </span></label><small>(e.g. street, block, lot, unit)</small>
                                <input type="text" class="form-control" placeholder="Home Address" name="home_address"
                                    id="home_address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="contact">Contact <span style="color:red"> * </span></label>
                                <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact Number">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email <span style="color:red"> * </span></label>
                          <input id="email" type="email" name="email" :value="old('email')" required class="form-control" placeholder="user@gmail.com">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="region">Employee Number <span style="color:red"> * </span></label>
                            <input type="text" class="form-control" id="employee_code" name="employee_code" placeholder="Employee Number">
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="region">Company <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" id="company_name" name="company_name">
                                <option value="" disabled selected>Select...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="region">Department <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" id="department" name="department">
                                <option value="" disabled selected>Select...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="region">Position <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" id="position" name="position">
                                <option value="" disabled selected>Select...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="region">Level of Access <span style="color:red"> * </span></label>
                            <select class="selectpicker form-control" id="access" name="access">
                                <option value="" disabled selected>Select...</option>
                            </select>
                        </div>
                    </div>

                   
                </div>
              <button type="submit" class="btn btn-primary me-2">Save</button>
              <button class="btn btn-light">Cancel</button>
            </form>
          </div>
        </div>
      </div>
</div>
@endsection
@section('js')
<script>
$(function(){
  $('#date_of_birth').datepicker();
});
</script>
<script src="{{ asset('assets/js/ph_address.js') }}"></script>
<script>
    $(function() {
        $('#date_of_birth').datepicker();

    });
</script>

<script>
    $(document).ready(function() {
        $("#add_new_user_form").validate({
                rules: {
                    firstname: "required",
                    lastname: "required",
                    middlename: "required",
                    suffix: "required",
                    date_of_birth: "required",
                    sex: "required",
                    civil_status: "required",
                    religion: "required",
                    region: "required",
                    province: "required",
                    city: "required",
                    barangay: "required",
                    home_address: "required",
                    contact: "required",
                    email: "required",
                    company_name: "required",
                    department: "required",
                    position: "required",
                    access: "required",
                    employee_code: "required",

                },
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    middlename: "Please enter your middlename",
                    suffix: "Please enter your suffix",
                    date_of_birth: "Please enter your date of birth",
                    sex: "Please enter your sex",
                    civil_status: "Please enter your civil status",
                    religion: "Please enter your religion",
                    region: "Please enter your region",
                    province: "Please enter your province",
                    city: "Please enter your city",
                    barangay: "Please enter your barangay",
                    home_address: "Please enter your home address",
                    contact: "Please enter your contact",
                    email: "Please enter your email",
                    company_name: "Please enter your company",
                    department: "Please enter your department",
                    position: "Please enter your position",
                    access: "Please enter your level of access",
                    employee_code: "Please enter your employee number",
                },
                onfocusout: function (e) {
                    this.element(e);
                },
                onkeyup: false,
                highlight: function(element, errorClass, validClass) {
                    jQuery(element).closest('.form-control').addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    jQuery(element).closest('.form-control').removeClass('is-invalid');
                    jQuery(element).closest('.form-control').addClass('is-valid');
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group-prepend').length) {
                        $(element).siblings(".invalid-feedback").append(error);
                        //error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Save it!',
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                        }).then((result) => {
                            if (result.value) {

                                
                                var formData = new FormData($("#add_new_user_form").get(0));
                                formData.append('txtRegion', $("#region :selected").text());

                                $.ajax({
                                    url: '/save-new-user',
                                    type: "POST",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: "JSON",
                                    beforeSend: function(){
                                        processObject.showProcessLoader();
                                    },
                                    success: function (data) {
                                        if (data.success) {
                                            // $('#adduserModal').modal('hide');
                                            $("#add_new_user_form")[0].reset();
                                            var form = $("#add_new_user_form");
                                            form.validate().resetForm();
                                            form.find(".error").removeClass("error");
                                            //reset form
                                            form.find('.form-control').removeClass('is-valid');
                                            swal.fire({
                                                title: "Saved!",
                                                text: "Successfully Saved!",
                                                icon: 'success',
                                                type: "success",
                                                html: "<b>Successfully Saved",
                                                // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                            });

                                            
                                        } else {
                                            swal.fire({
                                            title: "Oops! Something went wrong.",
                                            icon: 'error',
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                            type: "error",
                                        });
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        swal.fire({
                                            title: "Oops! something went wrong.",
                                            html: "<b>" + errorThrown +"! <br>An unexpected error seems to have occured. Why not try refreshing your page? Or you can contact us if the problem persists.</b>",
                                            type: "error",
                                        });
                                    },
                                    complete: function(){
                                        processObject.hideProcessLoader();
                                    },
                                });
                            }
                        })
                        // ---
                }
            });
    });
</script>

<script>
    //Start of Function for Address
    let myData = data;
    let region = '';
    let province = '';
    let counter = 1;

    var departmentID,positionID;
    $(document).ready(function() {
        addressAutoFill('#region', '#province', '#city', '#barangay');
        addressAutoFill('#region-2', '#province-2', '#city-2', '#barangay-2');
    });

    $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="company_name"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');


              

                    // $('.selectpicker').selectpicker('refresh');
                }

            }
        });


         $("#company_name").change(function() {
            $("#department").prop('disabled', false);
            $("#department").empty();
            $("#position").prop('disabled', false);
            $("#position").empty();

            $.ajax({
                url: '{{ route('get-company-has-department') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'company_id': $("#company_name").val()
                },
                dataType: "JSON",
                success: function(response) {
                    for (let index = 0; index < response.length; index++) {
                        $('[name="department"]').append('<option value=' + response[index].departments_info.id + '>' +
                        response[index].departments_info.name + '</option>');
                        departmentID = response[index].departments_info.id;
                  

                    }

                    $("#department").trigger('change');
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        $("#department").change(function() {
            $("#position").prop('disabled', false);
            $("#position").empty();
            $.ajax({
                url: '{{ route('get-department-has-position') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'department_id': $("#department").val()
                },
                dataType: "JSON",
                success: function(response) {
                    for (let index = 0; index < response.length; index++) {
                        $('[name="position"]').append('<option value=' + response[index].position.id + '>' +
                        response[index].position.name + '</option>');
                       
                    }

                    $("#position").trigger('change');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });

        $("#position").change(function() {
            $("#access").prop('disabled', false);
            $("#access").empty();
            $.ajax({
                url: '{{ route('get-position-has-access') }}',
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    'company_id':$("#company_name").val(),
                    'department_id':$("#department").val(),
                    'position_id': $("#position").val()
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    for (let index = 0; index < response.length; index++) {
                        $('[name="access"]').append('<option value=' + response[index].id + '>' +
                        response[index].permission.permission_description + '</option>');
                    }

                    // $("#department_acronyms").text(response[0].department.acronym);
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });




    function addressAutoFill(selectRegion, selectProvince, selectCity, selectBarangay) {
        var $select = $(selectRegion);
        $.each(myData, function(index, value) {
            $select.append('<option value="' + index + '">' + value.region_name + '</option>');
        });

        $(selectRegion).on('change', function() {
            var selectedRegion = $(this).children("option:selected").val();
            region = selectedRegion;
            var $select = $(selectProvince);
            var $select_city = $(selectCity);
            var $select_brgy = $(selectBarangay);
            $select.empty()
            $select_city.empty()
            $select_brgy.empty()
            $select.append('<option value="" disabled selected>Select.....</option>');
            $select_city.append('<option value="" disabled selected>Select.....</option>');
            $select_brgy.append('<option value="" disabled selected>Select.....</option>');
            $.each(myData[selectedRegion].province_list, function(index, value) {
                $select.append('<option value="' + index + '">' + index + '</option>');
            });
        });

        $(selectProvince).on('change', function() {
            var selectedProvince = $(this).children("option:selected").val();
            province = selectedProvince;
            var $select = $(selectCity);
            var $select_brgy = $(selectBarangay);
            $select.empty()
            $select_brgy.empty()
            $select.append('<option value="" disabled selected>Select.....</option>');
            $select_brgy.append('<option value="" disabled selected>Select.....</option>');
            $.each(myData[region].province_list[selectedProvince].municipality_list, function(index, value) {
                $select.append('<option value="' + index + '">' + index + '</option>');
            });
        });

        $(selectCity).on('change', function() {
            var selectedCity = $(this).children("option:selected").val();
            var $select = $(selectBarangay);
            $select.empty()
            $select.append('<option value="" disabled selected>Select.....</option>');
            $.each(myData[region].province_list[province].municipality_list[selectedCity].barangay_list,
                function(index, value) {
                    $select.append('<option value="' + value + '">' + value + '</option>');
                });

        });
    }
    //End of Function for Address
</script>
@endsection