@extends('admin.layout')

@section('content')
    <link href="/adminAsset/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/adminAsset/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <script src="/adminAsset/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/adminAsset/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="/adminAsset/plugins/datatables/jszip.min.js"></script>
    <script src="/adminAsset/plugins/datatables/pdfmake.min.js"></script>
    <script src="/adminAsset/plugins/datatables/vfs_fonts.js"></script>
    <script src="/adminAsset/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/adminAsset/plugins/datatables/buttons.print.min.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="/adminAsset/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.colVis.js"></script>
    <script src="/adminAsset/plugins/datatables/dataTables.fixedColumns.min.js"></script>
    <script src="/adminAsset/pages/datatables.init.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({keys: true});
            $('#datatable-responsive').DataTable();
            $('#datatable-colvid').DataTable({
                "dom": 'C<"clear">lfrtip',
                "colVis": {
                    "buttonText": "Change columns"
                }
            });
            $('#datatable-scroller').DataTable({
                ajax: "/adminAsset/plugins/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
            var table = $('#datatable-fixed-col').DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                }
            });
        });
        TableManageButtons.init();
    </script>
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b>Tefway</b></h4>
                            <form class="form-horizontal group-border-dashed" action="/admin/payments/update">
                                <div class="form-group">
                                    <label class="col-sm-3" style="padding-top: 7px;margin-bottom: 0;">Status</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" required name="tefway_active">
                                                <option @if ($settings->tefway_active == 1) selected @endif value="1">Ativado</option>
                                                <option @if ($settings->tefway_active == 0) selected @endif value="0">Desativado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" style="padding-top: 7px;margin-bottom: 0;">Modo</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" required name="tefway_test">
                                                <option @if ($settings->tefway_test == 1) selected @endif value="1">Teste</option>
                                                <option @if ($settings->tefway_test == 0) selected @endif value="0">Produção</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 15px;">
                                    <label class="col-sm-3" style="padding-top: 7px;margin-bottom: 0;">Tefway Token</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required value="{{$settings->tefway_token}}" name="tefway_token">
                                    </div>
                                    <div class="col-sm-3" style="display: flex;justify-content: end;">
                                        <button type="submit" class="btn btn-primary">
                                            Validar Token
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" style="padding-top: 7px;margin-bottom: 0;">Chave PIX</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" required name="tefway_pix">
                                            @foreach($keys as $key)
                                                <option @if ($settings->tefway_pix == $key) selected @endif value="{{$key}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3" style="display: flex;justify-content: end;">
                                        <button type="submit" class="btn btn-primary">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection