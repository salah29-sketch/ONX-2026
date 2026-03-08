@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">
Create marketing Package
</div>

<div class="card-body">

<form method="POST" action="{{ route('admin.adPackages.store') }}">

@csrf


<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>


<div class="form-group">
<label>Subtitle</label>
<input type="text" name="subtitle" class="form-control">
</div>


<div class="form-group">
<label>Description</label>
<textarea name="description" class="form-control"></textarea>
</div>


<div class="form-group">
<label>Type</label>

<select name="type" class="form-control">

<option value="monthly">Monthly Package</option>
<option value="custom">Custom Ad</option>

</select>

</div>


<div class="form-group">
<label>Price</label>
<input type="number" name="price" class="form-control">
</div>


<div class="form-group">
<label>Price Note</label>
<input type="text" name="price_note" class="form-control">
</div>


<div class="form-group">
<label>Features (one per line)</label>

<textarea name="features" class="form-control" rows="5"></textarea>

</div>


<div class="form-group">
<label>Sort Order</label>
<input type="number" name="sort_order" class="form-control" value="0">
</div>


<div class="form-group">

<label>
<input type="checkbox" name="is_featured" value="1">
Featured
</label>

</div>


<div class="form-group">

<label>
<input type="checkbox" name="is_active" value="1" checked>
Active
</label>

</div>


<button class="btn btn-primary">
Save
</button>

</form>

</div>
</div>

@endsection