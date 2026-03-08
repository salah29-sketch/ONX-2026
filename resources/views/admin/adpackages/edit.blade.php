@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">
Edit marketing Package
</div>

<div class="card-body">

<form method="POST"
action="{{ route('admin.adPackages.update',$adpackage->id) }}">

@csrf
@method('PUT')


<div class="form-group">
<label>Name</label>

<input type="text"
name="name"
class="form-control"
value="{{ $adpackage->name }}">
</div>


<div class="form-group">
<label>Subtitle</label>

<input type="text"
name="subtitle"
class="form-control"
value="{{ $adpackage->subtitle }}">
</div>


<div class="form-group">
<label>Description</label>

<textarea name="description"
class="form-control">{{ $adpackage->description }}</textarea>

</div>


<div class="form-group">
<label>Type</label>

<select name="type" class="form-control">

<option value="monthly"
@if($adpackage->type=='monthly') selected @endif>
Monthly
</option>

<option value="custom"
@if($adpackage->type=='custom') selected @endif>
Custom
</option>

</select>

</div>


<div class="form-group">
<label>Price</label>

<input type="number"
name="price"
class="form-control"
value="{{ $adpackage->price }}">
</div>


<div class="form-group">
<label>Price Note</label>

<input type="text"
name="price_note"
class="form-control"
value="{{ $adpackage->price_note }}">
</div>


<div class="form-group">
<label>Features</label>

<textarea name="features"
class="form-control"
rows="5">{{ $adpackage->features ? implode("\n", (array)$adpackage->features) : '' }}</textarea>

</div>


<div class="form-group">
<label>Sort Order</label>

<input type="number"
name="sort_order"
class="form-control"
value="{{ $adpackage->sort_order }}">
</div>


<div class="form-group">

<label>
<input type="checkbox"
name="is_featured"
value="1"
{{ $adpackage->is_featured ? 'checked':'' }}>
Featured
</label>

</div>


<div class="form-group">

<label>
<input type="checkbox"
name="is_active"
value="1"
{{ $adpackage->is_active ? 'checked':'' }}>
Active
</label>

</div>


<button class="btn btn-primary">
Update
</button>

</form>

</div>
</div>

@endsection