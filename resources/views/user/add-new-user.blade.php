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
                <label for="firstname">(<span style="color:red"> * </span>)の箇所を記入してください .</label>
              
                <form class="forms-sample" id="add_new_user_form" method="POST">
                    @csrf
                    @method('POST')
                    <br>
                    <br>
                    <h5 class="modal-title" id="exampleModalLabel">個人インフォメーション</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="firstname">氏名 <span style="color:red"> * </span></label>
                                <input type="text" class="form-control " id="firstname" name="fullname"
                                    placeholder="個人情報">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_of_birth">生年月日 <span style="color:red"> * </span></label>
                                {{-- <input type="text" class="form-control" id="date_of_birth" /> --}}

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <span class="mdi mdi-calendar-plus"></span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="date_of_birth" name="date_of_birth"
                                        placeholder="生年月日">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sex">性別 <span style="color:red"> * </span></label>
                                <select class="selectpicker form-control" data-live-search="true" name="sex" id="sex">
                                    <option value="" disabled="" selected="">選択...</option>
                                    <option value="Male">男性</option>
                                    <option value="Female">女性</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="home_address">自宅住所 <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" placeholder="自宅住所"
                                        name="home_address" id="home_address"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">電子メール <span style="color:red"> * </span></label>
                                <input id="email" type="email" name="email" :value="old('email')" required
                                    class="form-control" placeholder="user@gmail.com">
                            </div>
                        </div>
                    </div>
                    <br>
                    <h5 class="modal-title" id="exampleModalLabel">ユーザーアクセス</h5>
                    <hr>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="region">会社名 <span style="color:red"> * </span></label>
                                <select class="selectpicker form-control" id="company_name" name="company_name">
                                    <option value="" disabled selected>選択...</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="region">部署 <span style="color:red"> * </span></label>
                                <select class="selectpicker form-control" id="department" name="department">
                                    <option value="" disabled selected>選択...</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="region">役職 <span style="color:red"> * </span></label>
                                <select class="selectpicker form-control" id="position" name="position">
                                    <option value="" disabled selected>選択...</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="region">アクセスレベル <span style="color:red"> * </span></label>
                                <select class="selectpicker form-control" id="access" name="access">
                                    <option value="" disabled selected>選択...</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <button type="submit" class="btn btn-primary me-2">保存</button>
                    <button type="button" onclick="clearFields()" class="btn btn-light">キャンセル</button>
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
<script>
    const clearFields = () =>
    {
        $("#add_new_user_form")[0].reset();
        var form = $("#add_new_user_form");
        form.validate().resetForm();
        form.find(".error").removeClass("error");
        form.find('.form-control').removeClass('is-valid');
    }
</script>

<script>
    $(document).ready(function() {
        $("#add_new_user_form").validate({
                rules: {
                    fullname: "required",
                    date_of_birth: "required",
                    sex: "required",
                    home_address: "required",
                    email: "required",
                    company_name: "required",
                    department: "required",
                    position: "required",
                    access: "required",

                },
                messages: {
                    fullname: "氏名の入力をお願いします",
                    date_of_birth: "生年月日の入力をお願いします",
                    sex: "性別の入力をお願いします",
                    home_address: "住所の入力をお願いします",
                    email: "メールアドレスの入力をお願いします",
                    company_name: "会社名の入力をお願いします",
                    department: "部署の入力をお願いします",
                    position: "役職の入力をお願いします",
                    access: "アクセスレベルの入力をお願いします",
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
                        title: '保存してもよろしいですか？',
                        text: "元に戻すことはできません",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: "キャンセル",   
                        confirmButtonText: 'はい。保存いたします。',
                        //footer: '<a href = "mailto: jvn-cgs.com">Send an email to us!</a>'
                        }).then((result) => {
                            if (result.value) {

                                
                                var formData = new FormData($("#add_new_user_form").get(0));

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
                                                title: "正しく保存されました。",
                                                text: "正しく保存されました。",
                                                icon: 'success',
                                                type: "success",
                                                // html: "<b>Successfully Saved",
                                                // footer: '<a href = "mailto: enterprise.cabuyao@gmail.com">Send an email to us!</a>'
                                            });

                                            
                                        } else {
                                            swal.fire({
                                            title: "予期しないエラーが発生いたしました。",
                                            icon: 'error',
                                            html: "<b>" + data
                                                .messages +
                                                "! <br>もしくは管理業者までお問い合わせお願い致します。</b>",
                                            type: "error",
                                        });
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        swal.fire({
                                            title: "予期しないエラーが発生いたしました。",
                                            html: "<b>" + errorThrown +"! <br>もしくは管理業者までお問い合わせお願い致します。</b>",
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

    var departmentID,positionID;

    $.ajax({
            url: '{{ route('get-all-company') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
              
                for (let index = 0; index < response.length; index++) {
                    // console.log(response[index].vehicle_type_name);
                    $('[name="company_name"]').append('<option value=' + response[index].id + '>' +
                        response[index].company_name + '</option>');
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
                    for (let index = 0; index < response.length; index++) {
                        $('[name="access"]').append('<option value=' + response[index].id + '>' +
                        response[index].permission.permission_description + '</option>');
                    }
                    
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