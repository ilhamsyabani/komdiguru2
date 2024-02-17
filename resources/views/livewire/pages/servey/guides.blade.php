<div>
    <x-slot name="header">
        <div class="section-header">
            <h1>Petunjuk</h1>
        </div>
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4>{{$content->title}}</h4>
        </div>
        <div class="card-body">
            <p>{{$content->content}}</p>
            This user have role
        </div>
        <div class="form-group row mb-0 mt-3">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary" name="aksi" value="simpan">
                    Simpan
                </button>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</div>
