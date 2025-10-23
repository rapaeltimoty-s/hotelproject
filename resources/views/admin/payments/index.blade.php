@extends('layouts.admin')
@section('title','Admin • Payments')
@section('page_title','Payments')

@section('content')
<div class="container-fluid">

  <div class="card card-soft mb-3">
    <div class="card-body">
      <form method="GET" class="row g-2 g-md-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Cari (OrderID / Email)</label>
          <input class="form-control rounded-4" name="q" value="{{ $q }}" placeholder="e.g. BKG-... atau user@mail.com">
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select class="form-select rounded-4" name="status">
            @php $statuses=['','pending','success','failed','expired','refunded']; @endphp
            @foreach($statuses as $s)
              <option value="{{ $s }}" @selected($status===$s)>{{ $s===''?'(Semua)':ucfirst($s) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Gateway</label>
          <select class="form-select rounded-4" name="gateway">
            <option value="">(Semua)</option>
            @foreach($gateways as $g)
              <option value="{{ $g }}" @selected($gateway===$g)>{{ ucfirst($g) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Metode</label>
          <select class="form-select rounded-4" name="method">
            <option value="">(Semua)</option>
            @foreach($methods as $m)
              <option value="{{ $m }}" @selected($method===$m)>{{ strtoupper($m) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <label class="form-label">Dari</label>
          <input type="date" class="form-control rounded-4" name="date_from" value="{{ $from }}">
        </div>
        <div class="col-md-1">
          <label class="form-label">Sampai</label>
          <input type="date" class="form-control rounded-4" name="date_to" value="{{ $to }}">
        </div>
        <div class="col-md-1 d-grid">
          <button class="btn btn-brand btn-pill"><i class="bi bi-search"></i></button>
        </div>
      </form>
      <div class="mt-2">
        <a class="btn btn-ghost btn-pill btn-sm" href="{{ route('admin.payments.export.csv', request()->query()) }}"><i class="bi bi-download"></i> Export CSV</a>
      </div>
    </div>
  </div>

  <div class="table-responsive card card-soft">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Order ID</th>
          <th>User</th>
          <th>Hotel / Room</th>
          <th class="text-end">Amount</th>
          <th>Gateway</th>
          <th>Method</th>
          <th>Status</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($payments as $p)
        <tr>
          <td><a href="{{ route('admin.payments.show',$p->id) }}" class="text-decoration-none">{{ $p->order_id }}</a></td>
          <td>
            <div class="small">{{ $p->booking->user->name ?? '-' }}</div>
            <div class="small text-muted-ink">{{ $p->booking->user->email ?? '' }}</div>
          </td>
          <td class="small">
            <div>{{ $p->booking->room->hotel->name ?? '-' }}</div>
            <div class="text-muted-ink">{{ $p->booking->room->name ?? '' }}</div>
          </td>
          <td class="text-end fw-semibold">Rp {{ number_format($p->amount,0,',','.') }}</td>
          <td>{{ ucfirst($p->gateway) }}</td>
          <td>{{ strtoupper($p->method ?? '-') }}</td>
          <td>
            @php
              $map = ['success'=>'status-confirmed','pending'=>'status-pending','failed'=>'status-cancelled','expired'=>'status-cancelled','refunded'=>'status-pending'];
            @endphp
            <span class="status-badge {{ $map[$p->status] ?? 'status-pending' }}">{{ ucfirst($p->status) }}</span>
          </td>
          <td class="small">
            <div>{{ $p->created_at->format('d M Y H:i') }}</div>
            @if($p->paid_at)<div class="text-success">Paid: {{ $p->paid_at->format('d M Y H:i') }}</div>@endif
          </td>
          <td class="d-flex gap-1">
            <a class="btn btn-ghost btn-sm" href="{{ route('admin.payments.show',$p->id) }}"><i class="bi bi-eye"></i></a>

            @if(!in_array($p->status,['success','refunded']))
              <form method="POST" action="{{ route('admin.payments.markPaid',$p->id) }}">@csrf @method('PATCH')
                <button class="btn btn-outline-success btn-sm" title="Mark paid" onclick="return confirm('Tandai sukses?')"><i class="bi bi-check2-circle"></i></button>
              </form>
            @endif

            @if(!in_array($p->status,['failed','refunded']))
              <form method="POST" action="{{ route('admin.payments.markFailed',$p->id) }}">@csrf @method('PATCH')
                <button class="btn btn-outline-danger btn-sm" title="Mark failed" onclick="return confirm('Tandai gagal?')"><i class="bi bi-x-circle"></i></button>
              </form>
            @endif
          </td>
        </tr>
        @empty
          <tr><td colspan="9" class="text-center text-muted-ink">Belum ada transaksi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    @if(method_exists($payments,'links')) {{ $payments->links() }} @endif
  </div>
</div>
@endsection
