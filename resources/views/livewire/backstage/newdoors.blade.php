<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ 'Naujų durų registracija' }}</div>

                <div class="card-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('doors/insert') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label>Durų pavadinimas:</label>
                            <div>
                                <input type="text" class="form-control" name="name" required
                                       value="">
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label>IP adresas</label>
                                    <input type="text" id="ip" class="form-control" name="ip" required
                                           value="">
                                </div>
                                <div class="col">
                                    <label>Portas</label>
                                    <input type="text" id="port" class="form-control" name="port" required
                                           value="">
                                </div>
                                <div class="col-3">
                                    <label>Durų id valdiklyje:</label>
                                    <input type="text" id="door_id" class="form-control" name="door_id" required
                                           value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Skyrius:</label>
                                <input type="text" class="form-control" name="department"
                                       value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                    Pridėti duris
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <button class="btn btn-primary" onclick="connect()">Tikrinti durų ryšį</button>

            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function connect() {
            var ip = document.getElementById('ip').value;
            var port = document.getElementById('port').value;
            $.post('{{ route('doors.check_status') }}', {ip: ip, port: port}, function (response) {
                if (!response.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ojojoj!',
                        text: 'Nepavyko prisijungti!',
                        timer: 2500
                    })
                } else
                    Swal.fire({
                        icon: 'success',
                        title: 'Valio',
                        text: 'Ryšys yra!',
                        timer: 1500
                    })
            });
        }
    </script>
@endpush
