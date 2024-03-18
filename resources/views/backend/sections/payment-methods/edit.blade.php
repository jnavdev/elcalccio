@extends('backend.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Actualizar registro</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Forma de Pago</h3>
                        </div>

                        <form action="{{ route('payment_methods.update', $paymentMethod) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="account_number">Numero Cuenta</label>
                                            <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" class="form-control @error('account_number') is-invalid @enderror" placeholder="Ingrese numero de cuenta">
                                            @error('account_number')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="bank">Banco</label>
                                            <select name="bank" id="bank" class="form-control @error('bank') is-invalid @enderror">
                                                <option value="">Seleccione</option>
                                                <option value="Banco de Chile" {{ $paymentMethod->bank == 'Banco de Chile' ? 'selected' : '' }}>Banco de Chile</option>
                                                <option value="Banco de Credito e Inversiones" {{ $paymentMethod->bank == 'Banco de Credito e Inversiones' ? 'selected' : '' }}>Banco de Credito e Inversiones</option>
                                                <option value="Banco Estado" {{ $paymentMethod->bank == 'Banco Estado' ? 'selected' : '' }}>Banco Estado</option>
                                                <option value="Banco Santander" {{ $paymentMethod->bank == 'Banco Santander' ? 'selected' : '' }}>Banco Santander</option>
                                                <option value="BBVA" {{ $paymentMethod->bank == 'BBVA' ? 'selected' : '' }}>BBVA</option>
                                                <option value="Corpbanca" {{ $paymentMethod->bank == 'Corpbanca' ? 'selected' : '' }}>Corpbanca</option>
                                                <option value="SCOTIABANK" {{ $paymentMethod->bank == 'SCOTIABANK' ? 'selected' : '' }}>SCOTIABANK</option>
                                                <option value="Banco Falabella" {{ $paymentMethod->bank == 'Banco Falabella' ? 'selected' : '' }}>Banco Falabella</option>
                                            </select>
                                            @error('bank')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Descripcion</label>
                                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Ingrese descripcion">{{ old('description', $paymentMethod->description) }}</textarea>
                                            @error('description')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="executive_name">Nombre Ejecutivo</label>
                                            <input type="text" name="executive_name" id="executive_name" value="{{ old('executive_name', $paymentMethod->executive_name) }}" class="form-control @error('executive_name') is-invalid @enderror" placeholder="Ingrese nombre ejecutivo">
                                            @error('executive_name')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-secondary" href="{{ route('payment_methods.index') }}">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
