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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                    <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-user" style="color: white !important;"></i>
                        Detalles del Usuario
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                        <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 1.5rem; background: #F9FAFB;">
                    <!-- Información Personal -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-circle-info"></i>
                            Información Personal
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Nombre</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserName"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Email</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserEmail"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Empresa</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserCompany"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Rol</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserRole"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Estado</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserStatus"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Actividad -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-clock"></i>
                            Información de Actividad
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Último Acceso</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserLastLogin"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha de Registro</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="modalUserCreated"></div>
                            </div>
                        </div>
                    </div>
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
        dom: 'lBfrtip',
        buttons: [
            {
                extend: "copyHtml5",
                text: "<i class='fa fa-copy'></i> Copiar",
                titleAttr: "Copiar",
                className: "btn btn-secondary"
            },
            {
                extend: "excelHtml5",
                text: "<i class='fa fa-file-excel-o'></i> Excel",
                titleAttr: "Exportar a Excel",
                className: "btn btn-success"
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fa fa-file-pdf-o'></i> PDF",
                titleAttr: "Exportar a PDF",
                className: "btn btn-danger"
            }
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
