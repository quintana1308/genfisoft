@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">Gestión de Usuarios</h4>
                                <p class="card-category">Administrar todos los usuarios del sistema</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-round">
                                    <i class="fa fa-plus"></i> Crear Usuario
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Empresa</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Último Acceso</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles del usuario -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nombre:</strong>
                            <p id="modalUserName"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p id="modalUserEmail"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Empresa:</strong>
                            <p id="modalUserCompany"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Rol:</strong>
                            <p id="modalUserRole"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Rebaño:</strong>
                            <p id="modalUserRebano"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <p id="modalUserStatus"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Último Acceso:</strong>
                            <p id="modalUserLastLogin"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Registro:</strong>
                            <p id="modalUserCreated"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("admin.users.data") }}',
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'company', name: 'company' },
            { data: 'role', name: 'role' },
            { 
                data: 'is_active', 
                name: 'is_active',
                render: function(data, type, row) {
                    return data ? 
                        '<span class="badge badge-success">Activo</span>' : 
                        '<span class="badge badge-danger">Inactivo</span>';
                }
            },
            { data: 'last_login', name: 'last_login' },
            { data: 'created_at', name: 'created_at' },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var actions = '<div class="btn-group" role="group">';
                    
                    // Botón ver detalles
                    actions += '<button class="btn btn-info btn-sm view-user" data-id="' + data + '" title="Ver detalles">';
                    actions += '<i class="fa fa-eye"></i></button>';
                    
                    // Botón editar
                    actions += '<a href="{{ route("admin.users.edit", ":id") }}" class="btn btn-warning btn-sm" title="Editar">'.replace(':id', data);
                    actions += '<i class="fa fa-edit"></i></a>';
                    
                    // Botón toggle estado
                    var statusBtn = row.is_active ? 
                        '<button class="btn btn-secondary btn-sm toggle-status" data-id="' + data + '" title="Desactivar">' +
                        '<i class="fa fa-ban"></i></button>' :
                        '<button class="btn btn-success btn-sm toggle-status" data-id="' + data + '" title="Activar">' +
                        '<i class="fa fa-check"></i></button>';
                    actions += statusBtn;
                    
                    // Botón eliminar (solo si no es el usuario actual)
                    if (data != {{ Auth::id() }}) {
                        actions += '<button class="btn btn-danger btn-sm delete-user" data-id="' + data + '" title="Eliminar">';
                        actions += '<i class="fa fa-trash"></i></button>';
                    }
                    
                    actions += '</div>';
                    return actions;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        },
        order: [[0, 'desc']]
    });

    // Ver detalles del usuario
    $(document).on('click', '.view-user', function() {
        var userId = $(this).data('id');
        
        $.get('{{ route("admin.users.show", ":id") }}'.replace(':id', userId))
            .done(function(data) {
                $('#modalUserName').text(data.name);
                $('#modalUserEmail').text(data.email);
                $('#modalUserCompany').text(data.company);
                $('#modalUserRole').text(data.role.charAt(0).toUpperCase() + data.role.slice(1));
                $('#modalUserRebano').text(data.rebaño || 'No especificado');
                $('#modalUserStatus').html(data.is_active ? 
                    '<span class="badge badge-success">Activo</span>' : 
                    '<span class="badge badge-danger">Inactivo</span>'
                );
                $('#modalUserLastLogin').text(data.last_login);
                $('#modalUserCreated').text(data.created_at);
                
                $('#userDetailsModal').modal('show');
            })
            .fail(function() {
                Swal.fire('Error', 'No se pudieron cargar los detalles del usuario', 'error');
            });
    });

    // Toggle estado del usuario
    $(document).on('click', '.toggle-status', function() {
        var userId = $(this).data('id');
        var button = $(this);
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas cambiar el estado de este usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.users.toggle-status", ":id") }}'.replace(':id', userId),
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Éxito', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al cambiar el estado', 'error');
                    }
                });
            }
        });
    });

    // Eliminar usuario
    $(document).on('click', '.delete-user', function() {
        var userId = $(this).data('id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.users.delete", ":id") }}'.replace(':id', userId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Eliminado', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error al eliminar el usuario', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
