{{-- إجراءات العملاء: عرض، تعطيل الدخول، إعادة تعيين كلمة السر، حذف --}}
<a class="btn btn-xs btn-primary mr-1 mb-1" href="{{ route('admin.clients.show', $row->id) }}" title="عرض التفاصيل">
    <i class="fas fa-eye"></i>
</a>

<form action="{{ route('admin.clients.toggle-login', $row->id) }}" method="POST" class="d-inline-block mr-1 mb-1" onsubmit="return confirm('{{ $row->login_disabled ? 'تفعيل دخول هذا العميل؟' : 'تعطيل دخول هذا العميل؟' }}');">
    @csrf
    @if($row->login_disabled)
        <button type="submit" class="btn btn-xs btn-success" title="تفعيل الدخول"><i class="fas fa-unlock"></i></button>
    @else
        <button type="submit" class="btn btn-xs btn-warning" title="تعطيل الدخول"><i class="fas fa-lock"></i></button>
    @endif
</form>

<form action="{{ route('admin.clients.reset-password', $row->id) }}" method="POST" class="d-inline-block mr-1 mb-1" onsubmit="return confirm('سيتم إنشاء كلمة مرور جديدة وعرضها في صفحة التفاصيل مرة واحدة. متابعة؟');">
    @csrf
    <button type="submit" class="btn btn-xs btn-info" title="إعادة تعيين كلمة المرور"><i class="fas fa-key"></i></button>
</form>

@can('client_delete')
<form action="{{ route('admin.clients.destroy', $row->id) }}" method="POST" class="d-inline-block mb-1" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-xs btn-danger" title="حذف"><i class="fas fa-trash-alt"></i></button>
</form>
@endcan
