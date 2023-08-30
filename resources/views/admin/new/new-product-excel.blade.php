@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Yeni Ürün Listesi Ekle</h4>
                        <h5 class="card-subtitle"> Yeni ürün listenizi excel dosyası olarak ekleyebilirsiniz</h5>
                        <form class="row g-3 needs-validation" enctype="multipart/form-data" id="form" novalidate>
                            <div class="col-md-6 form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input input-fields"   id="import_file">
                                    {{ csrf_field() }}
                                    <label class="custom-file-label" >Choose file</label>
                                </div>
                            </div>


                            <button class="btn btn-primary" id="excel_form_submit">Import CSV or Excel File</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection

@section('scripts')
    <script>




        $('#excel_form_submit').on('click', function () {
            is_valid = validate_form('form');
            if (!is_valid) {
                return;
            }

            show_loader();
            let formData = new FormData();

            formData.append('import_file', document.getElementById("import_file").files[0]);


            fetch('{{route('importExcel')}}', {

                method: "POST",
                body: formData

            })
                .then(response => {
                    if (response.status == 301) {
                        window.location = '{{route('admin_panel_logout')}}';
                        throw new Error('Logging out...');
                    }
                    return response.json();

                })
                .then(data => {

                    if (data.result != '1') {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            confirmButtonColor: '#367ab2',
                        })
return;
                    }


                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        confirmButtonColor: '#367ab2',
                    })

                })
                .catch((error) => {

                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })

                });


        });
    </script>
@endsection
