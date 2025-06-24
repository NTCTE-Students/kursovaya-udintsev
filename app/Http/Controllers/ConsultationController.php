<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultation;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class ConsultationController extends Controller
{
    public function dashboard()
    {
        $consultants = User::where('role', 'consultant')->get();

        return view('dashboard', compact('consultants'));
    }

    // Показать форму бронирования консультации с выбором консультанта и тем
    public function create(Request $request)
    {
        $consultants = User::where('role', 'consultant')->get();

        $selectedConsultantId = $request->query('consultant_id');
        $topics = collect();

        if ($selectedConsultantId) {
            $consultant = User::find($selectedConsultantId);
            if ($consultant) {
                $topics = $consultant->topics;
            }
        }

        return view('consultations.create', compact('consultants', 'topics', 'selectedConsultantId'));
    }

    // Сохранить новую консультацию (бронирование)
    public function store(Request $request)
    {
        $request->validate([
            'consultant_id' => 'required|exists:users,id',
            'topic_id' => 'required|exists:topics,id',
            'scheduled_at' => 'required|date|after:now',
        ]);

        // Проверяем, что выбранная тема действительно принадлежит выбранному консультанту
        $topic = Topic::where('id', $request->topic_id)
            ->where('consultant_id', $request->consultant_id)
            ->first();

        if (!$topic) {
            return back()
                ->withErrors(['topic_id' => 'Выбранная тема не принадлежит выбранному консультанту'])
                ->withInput();
        }

        $scheduledAt = str_replace('T', ' ', $request->scheduled_at) . ':00';

        Consultation::create([
            'user_id' => Auth::id(),
            'consultant_id' => $request->consultant_id,
            'topic_id' => $request->topic_id,
            'scheduled_at' => $scheduledAt,
            'status' => 'pending',
        ]);

        return redirect()->route('consultations.index')->with('success', 'Консультация забронирована');
    }


    // Список консультаций текущего пользователя (как клиент)
    public function index()
    {
        $consultations = Consultation::where('user_id', Auth::id())
            ->with(['consultant', 'topic', 'payments'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('consultations.index', compact('consultations'));
    }

    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);

        // Только клиент или консультант, связанный с консультацией, может удалить
        if (Auth::id() !== $consultation->user_id && Auth::id() !== $consultation->consultant_id) {
            abort(403, 'Нет доступа к удалению этой консультации');
        }

        $consultation->delete();

        return redirect()->back()->with('success', 'Консультация удалена');
    }

    public function consultantIndex()
    {
        $consultations = Consultation::where('consultant_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('consultations.consultant', compact('consultations'));
    }

    public function asConsultant()
    {
        $consultations = Consultation::where('consultant_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('consultations.as_consultant', compact('consultations'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        if (Auth::id() !== $consultation->consultant_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);

        $consultation->status = $request->status;
        $consultation->save();

        return back()->with('success', 'Статус обновлён');
    }

    public function pay(Request $request, Consultation $consultation)
    {
        if (Auth::id() !== $consultation->user_id) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:card,paypal,sbp',
            'card_number' => 'required|digits:16',
        ]);

        $paymentSuccess = rand(0, 1) === 1;

        $status = $paymentSuccess ? 'success' : 'failed';

        Payment::create([
            'consultation_id' => $consultation->id,
            'amount' => 5000,
            'method' => $request->payment_method,
            'status' => $status,
            'paid_at' => Carbon::now(),
        ]);

        if (!$paymentSuccess) {
            return redirect()->back()->with('error', 'Оплата не прошла, попробуйте еще раз.');
        }

        $consultation->is_paid = true;
        $consultation->status = 'approved';
        $consultation->save();

        return redirect()->route('consultations.index')->with('success', 'Консультация успешно оплачена и подтверждена.');
    }

    public function topic()
{
    return $this->belongsTo(Topic::class);
}

}
