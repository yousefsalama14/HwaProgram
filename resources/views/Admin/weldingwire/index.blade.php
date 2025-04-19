@extends('admin_temp')
@section('content')
{{--start modal--}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">تعديل سعر سلك اللحام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                       <form method="post" action="{{route('weldingwires.update',0)}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group">
                            <label>size</label>
                         <input class="form-control" type="number" name="size" id="size" disabled>
                        </div>
                        <div class="form-group">
                            <label>price</label>
                          <input  class="form-control" type="text" name="price" id="price">
                        </div>

                         <input  class="btn btn-primary" type="submit" value="update">

                       </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{--end modal--}}
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <colgroup>
                <col>
                <col>
                <col style="width: 50px;">
                <col style="width: 50px;">
                <col style="width: 50px;">
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>نوع السلك</th>
                    <th class="text-center p-0">السعر</th>
                    <th class="text-center p-0">تعديل</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>نوع السلك</th>
                    <th class="text-center p-0">السعر</th>
                    <th class="text-center p-0">تعديل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($weldingwires as $key=>$weldingwire)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$weldingwire->name}} مم</td>
                    <td class="text-center p-0">
                        {{$weldingwire->price}}
                    </td>
                    <td class="text-center p-0">
                        <a href="#"  data-bs-toggle="modal"
                        data-bs-target="#paymentModal"><i
                        class="las la-edit text-secondary font-16"
                        onclick="wiredata({{$weldingwire->id}},{{$weldingwire->size}},{{$weldingwire->price}});"
                        ></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--end /table-->

    </div>
    <!--end /div-->
    <nav aria-label="..." class="py-3 border-top">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">السابق</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1 <span
                        class="sr-only">(current)</span></a></li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">التالي</a>
            </li>
        </ul>
        <!--end pagination-->
    </nav>
</div>

@endsection
@section('scripts')
<script>
let wiredata =(id,size,price)=>{
    document.getElementById('id').value=id;
    document.getElementById('size').value=size;
    document.getElementById('price').value=price;
}

</script>
@endsection
