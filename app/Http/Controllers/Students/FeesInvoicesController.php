<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\students;
use App\fees;
use App\Fee_invoices;
use App\Grade;
use App\StudentAccount;
use Illuminate\Support\Facades\DB;
class FeesInvoicesController extends Controller
{

    public function index()
    {
        $Fee_invoices = Fee_invoices::all();
        $Grades = Grade::all();
        return view('pages.Fees_Invoices.index',compact('Fee_invoices','Grades'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $List_Fees = $request->List_Fees;

        DB::beginTransaction();

        try {

            foreach ($List_Fees as $List_Fee) {
                // حفظ البيانات في جدول فواتير الرسوم الدراسية
                $Fees = new Fee_invoices();
                $Fees->invoice_date = date('Y-m-d');
                $Fees->student_id = $List_Fee['student_id'];
                $Fees->Grade_id = $request->Grade_id;
                $Fees->Classroom_id = $request->Classroom_id;;
                $Fees->fee_id = $List_Fee['fee_id'];
                $Fees->amount = $List_Fee['amount'];
                $Fees->description = $List_Fee['description'];
                $Fees->save();

                // حفظ البيانات في جدول حسابات الطلاب
                $StudentAccount = new StudentAccount();
                $StudentAccount->date = date('Y-m-d');
                $StudentAccount->type = 'invoice';
                $StudentAccount->fee_invoice_id = $Fees->id;
                $StudentAccount->student_id = $List_Fee['student_id'];
                $StudentAccount->Debit = $List_Fee['amount'];
                $StudentAccount->credit = 0.00;
                $StudentAccount->description = $List_Fee['description'];
                $StudentAccount->save();
            }

            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Fees_Invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = students::findorfail($id);
        $fees = fees::where('Classroom_id',$student->Classroom_id)->get();
        return view('pages.Fees_Invoices.add',compact('student','fees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fee_invoices = Fee_invoices::findorfail($id);
        $fees = fees::where('Classroom_id',$fee_invoices->Classroom_id)->get();
        return view('pages.Fees_Invoices.edit',compact('fee_invoices','fees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        DB::beginTransaction();
        try {
            // تعديل البيانات في جدول فواتير الرسوم الدراسية
            $Fees = Fee_invoices::findorfail($request->id);
            $Fees->fee_id = $request->fee_id;
            $Fees->amount = $request->amount;
            $Fees->description = $request->description;
            $Fees->save();

            // تعديل البيانات في جدول حسابات الطلاب
            $StudentAccount = StudentAccount::where('fee_invoice_id',$request->id)->first();
            $StudentAccount->Debit = $request->amount;
            $StudentAccount->description = $request->description;
            $StudentAccount->save();
            DB::commit();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Fees_Invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request
    )
    {
        try {
            Fee_invoices::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
