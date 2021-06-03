<?php

namespace App\Http\Controllers\User;

use App\Classes\ParionMailer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\AdminUserConversation;
use App\Models\AdminUserMessage;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Pagesetting;
use App\Models\User;
use Ramsey\Uuid\Uuid;


class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function messages()
    {
        $user = Auth::guard('web')->user();
        $convs = Conversation::where('sent_user', '=', $user->id)->orWhere('recieved_user', '=', $user->id)->get();
        return view('user.message.index', compact('user', 'convs'));
    }

    public function message($id)
    {
        $user = Auth::guard('web')->user();
        $conv = Conversation::findOrfail($id);
        return view('user.message.create', compact('user', 'conv'));
    }

    public function messagedelete($uuid)
    {
        $user = Auth::guard('web')->user();
        $conv = Conversation::where(['uuid' => $uuid, 'user_id' => $user->id])->firstOrFail();
        if ($conv->messages->count() > 0) {
            foreach ($conv->messages as $key) {
                $key->delete();
            }
        }
        $conv->delete();
        return redirect()->back()->with('success', 'Message Deleted Successfully');
    }

    public function msgload($id)
    {
        $conv = Conversation::findOrfail($id);
        return view('load.usermsg', compact('conv'));
    }

    //Send email to user
    public function usercontact(Request $request)
    {
        $data = 1;
        $user = User::findOrFail($request->user_id);
        $vendor = User::where('email', '=', $request->email)->first();
        if (empty($vendor)) {
            $data = 0;
            return response()->json($data);
        }

        $subject = $request->subject;
        $to = $vendor->email;
        $name = $request->name;
        $from = $request->email;
        $msg = "Name: " . $name . "\nEmail: " . $from . "\nMessage: " . $request->message;
        $gs = Generalsetting::findOrfail(1);
        if ($gs->is_smtp == 1) {
            $data = [
                'to' => $vendor->email,
                'subject' => $request->subject,
                'body' => $msg,
            ];

            $mailer = new ParionMailer();
            $mailer->sendCustomMail($data);
        } else {
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }

        $conv = Conversation::where('sent_user', '=', $user->id)->where('subject', '=', $subject)->first();
        if (isset($conv)) {
            $msg = new Message();
            $msg->conversation_id = $conv->id;
            $msg->message = $request->message;
            $msg->sent_user = $user->id;
            $msg->save();
            return response()->json($data);
        } else {
            $message = new Conversation();
            $message->subject = $subject;
            $message->sent_user = $request->user_id;
            $message->recieved_user = $vendor->id;
            $message->message = $request->message;
            $message->save();

            $msg = new Message();
            $msg->conversation_id = $message->id;
            $msg->message = $request->message;
            $msg->sent_user = $request->user_id;;
            $msg->save();
            return response()->json($data);
        }
    }

    public function postmessage(Request $request)
    {
        $msg = new Message();
        $input = $request->all();
        $msg->uuid = Uuid::uuid1();
        $msg->fill($input)->save();
        //--- Redirect Section
        $msg = 'Message Sent!';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    public function adminmessages()
    {
        $user = Auth::guard('web')->user();
        $convs = AdminUserConversation::where('type', '=', 'Ticket')->where('user_id', '=', $user->id)->get();
        return view('user.ticket.index', compact('convs'));
    }

    public function adminDiscordmessages()
    {
        $user = Auth::guard('web')->user();
        $convs = AdminUserConversation::where('type', '=', 'Dispute')->where('user_id', '=', $user->id)->orderByDesc('id')->get();
        $orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
        //return view('user.dispute.index',compact('convs'));
        return view('theme::pages.user.dispute.index', compact('convs', 'orders'));
    }

    public function messageload($uuid)
    {
        $user = Auth::guard('web')->user();
        $conv = AdminUserConversation::where(['user_id' => $user->id,'uuid' => $uuid])->firstOrFail();
        return view('theme::load.usermessage', compact('conv'));
    }

    public function adminmessage($uuid)
    {
        $user = Auth::guard('web')->user();
        $conv = AdminUserConversation::where(['user_id' => $user->id,'uuid' => $uuid])->firstOrFail();
        return view('theme::pages.user.dispute.show', compact('conv'));
        //return view('user.ticket.create', compact('conv'));
    }

    public function adminmessagedelete($uuid)
    {
        $user = Auth::guard('web')->user();
        $conv = AdminUserConversation::where(['uuid' => $uuid, 'user_id' => $user->id])->firstOrFail();
        if ($conv->messages->count() > 0) {
            foreach ($conv->messages as $key) {
                $key->delete();
            }
        }
        $conv->delete();
        return redirect()->back()->with('success', 'Mesaj basariyla silindi');
    }

    public function adminmessagesolve($uuid) {
        $user = Auth::guard('web')->user();
        $conv = AdminUserConversation::where(['uuid' => $uuid, 'user_id' => $user->id])->firstOrFail();
        $conv->status = 2;
        $conv->save();
        return redirect()->back()->with('success', 'Sorun cozuldu olarak isaretlendi.');
    }

    public function adminpostmessage(Request $request)
    {
        $msg = new AdminUserMessage();
        $input = $request->all();
        $msg->fill($input)->save();
        $notification = new Notification;
        $notification->conversation_id = $msg->conversation->id;
        $notification->save();
        //--- Redirect Section
        $msg = 'success';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    public function adminusercontact(Request $request)
    {
        $data = 1;
        $user = Auth::guard('web')->user();
        $gs = Generalsetting::findOrFail(1);
        $subject = $request->subject . ' | Sustaíly Musteri Sistemi';
        $to = Pagesetting::find(1)->contact_email;
        $from = $user->email;
        $msg = "Email: " . $from . "<br>Mesaj: " . $request->message;
        if ($request->type != 'Ticket') {
            $msg = "<br>Siparis ID: " . $request->order . '<br>' . $msg;
        }
        if ($gs->is_smtp == 1) {
            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];

            $mailer = new ParionMailer();
            $mailer->sendCustomMail($data);
        } else {
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }
        if ($request->type == 'Ticket') {
            $conv = AdminUserConversation::where('type', '=', 'Ticket')->where('user_id', '=', $user->id)->where('subject', '=', $subject)->first();
        } else {
            $conv = AdminUserConversation::where('type', '=', 'Dispute')->where('user_id', '=', $user->id)->where('subject', '=', $subject)->first();
        }

        if (isset($conv)) {
            $msg = new AdminUserMessage();
            $msg->conversation_id = $conv->id;
            $msg->message = $request->message;
            $msg->user_id = $user->id;
            $msg->save();
            return response()->json(['status' => 'success']);
        } else {
            Uuid::uuid4()
            $message = new AdminUserConversation();
            $message->subject = $subject;
            $message->user_id = $user->id;
            $message->message = $request->message;
            $message->order_number = $request->order;
            $message->type = $request->type;
            $message->uuid = Uuid::uuid1();
            $message->save();
            $notification = new Notification;
            $notification->conversation_id = $message->id;
            $notification->save();
            $msg = new AdminUserMessage();
            $msg->conversation_id = $message->id;
            $msg->message = $request->message;
            $msg->user_id = $user->id;
            $msg->save();
            return response()->json(['status' => 'success']);

        }
    }
}
