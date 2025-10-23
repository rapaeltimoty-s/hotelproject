@extends('layouts.admin')
@section('title','Payment • '.$payment->order_id)
@section('page_title','Payment Detail')

@section('content')
<div class="container-fluid">
  @if(session('status'))<div class="alert alert-success rounded-4">{{ session('status') }}</div>@endif
  @if($errors->any())<div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>@endif

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card card-soft">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="small text-muted-ink">Order ID</div>
              <div class="fw-semibold">{{ $payment->order_id }}</div>
            </div>
            @php
              $map = ['success'=>'status-confirmed','pending'=>'status-pending','failed'=>'status-cancelled','expired'=>'status-cancelled','refunded'=>'status-pending'];
            @endphp
            <span class="status-badge {{ $map[$payment->status] ?? 'status-pending' }}">{{ ucfirst($payment->status) }}</span>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6 small">
              <div class="text-muted-ink">User</div>
              <div class="fw-semibold">{{ $payment->booking->user->name ?? '-' }}</div>
              <div class="text-muted-ink">{{ $payment->booking->user->email ?? '' }}</div>
            </div>
            <div class="col-md-6 small">
              <div class="text-muted-ink">Hotel / Room</div>
              <div class="fw-semibold">{{ $payment->booking->room->hotel->name ?? '-' }}</div>
              <div class="text-muted-ink">{{ $payment->booking->room->name ?? '' }}</div>
            </div>
          </div>
          <div class="row mt-3 small">
            <div class="col-md-3">
              <div class="text-muted-ink">Gateway</div>
              <div class="fw-semibold">{{ ucfirst($payment->gateway) }}</div>
            </div>
            <div class="col-md-3">
              <div class="text-muted-ink">Method</div>
              <div class="fw-semibold">{{ strtoupper($payment->method ?? '-') }}</div>
            </div>
            <div class="col-md-3">
              <div class="text-muted-ink">Amount</div>
              <div class="fw-semibold">Rp {{ number_format($payment->amount,0,',','.') }}</div>
            </div>
            <div class="col-md-3">
              <div class="text-muted-ink">Refunded</div>
              <div class="fw-semibold">Rp {{ number_format($payment->refunded_amount,0,',','.') }}</div>
            </div>
          </div>
          <div class="row mt-3 small">
            <div class="col-md-4">
              <div class="text-muted-ink">Created</div>
              <div class="fw-semibold">{{ $payment->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="col-md-4">
              <div class="text-muted-ink">Paid at</div>
              <div class="fw-semibold">{{ $payment->paid_at?->format('d M Y H:i') ?? '-' }}</div>
            </div>
            <div class="col-md-4">
              <div class="text-muted-ink">Expires</div>
              <div class="fw-semibold">{{ $payment->expires_at?->format('d M Y H:i') ?? '-' }}</div>
            </div>
          </div>

          <hr>
          <div class="small text-muted-ink mb-1">Raw Payload</div>
          <pre class="small bg-light p-3 rounded-4" style="max-height:320px;overflow:auto">{{ json_encode($payment->raw_payload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card card-soft">
        <div class="card-body">
          <div class="fw-semibold mb-2">Aksi</div>
          <div class="d-flex flex-wrap gap-2">
            @if(!in_array($payment->status,['success','refunded']))
              <form method="POST" action="{{ route('admin.payments.markPaid',$payment->id) }}">@csrf @method('PATCH')
                <button class="btn btn-brand btn-pill btn-sm" onclick="return confirm('Tandai sukses?')"><i class="bi bi-check2-circle me-1"></i> Mark Paid</button>
              </form>
            @endif

            @if(!in_array($payment->status,['failed','refunded']))
              <form method="POST" action="{{ route('admin.payments.markFailed',$payment->id) }}">@csrf @method('PATCH')
                <button class="btn btn-outline-danger btn-pill btn-sm" onclick="return confirm('Tandai gagal?')"><i class="bi bi-x-circle me-1"></i> Mark Failed</button>
              </form>
            @endif
          </div>

          <hr>
          <div class="fw-semibold mb-2">Refund Manual</div>
          <form method="POST" action="{{ route('admin.payments.refund',$payment->id) }}" class="d-flex gap-2">
            @csrf
            <input type="number" class="form-control rounded-4" name="amount" min="1" placeholder="Nominal (Rp)" required>
            <button class="btn btn-outline-brand btn-pill">Refund</button>
          </form>

          <div class="small text-muted mt-2">Catatan: Ini pencatatan refund internal. Integrasi refund API gateway bisa ditambahkan di controller.</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
