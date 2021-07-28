<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">

                <div class="card-body" style="text-align: center" >

                    <div>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('doors/open_public'),  }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label >Atrakinimo kodas:</label>
                                <div>
                                    <input type="text" wire:model="unlock_code" name="unlock_id" data-role="keypad" data-position="bottom" data-key-length="4" placeholder="4 skaitmenų kodas" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                        Atrakinti
                                    </button>
                                </div>
                            </div>
                        </form>


            </div>
        </div>
    </div>
</div>
</div>

<style>input {text-align: center;}</style>
