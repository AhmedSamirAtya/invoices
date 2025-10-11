<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="invoice_number" class="form-label">{{ __('Invoice Number') }}</label>
            <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number', $invoice?->invoice_number) }}" id="invoice_number" placeholder="Invoice Number">
            {!! $errors->first('invoice_number', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="invoice__date" class="form-label">{{ __('Invoice Date') }}</label>
            <input type="text" name="invoice_Date" class="form-control @error('invoice_Date') is-invalid @enderror" value="{{ old('invoice_Date', $invoice?->invoice_Date) }}" id="invoice__date" placeholder="Invoice Date">
            {!! $errors->first('invoice_Date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
            <input type="text" name="Due_date" class="form-control @error('Due_date') is-invalid @enderror" value="{{ old('Due_date', $invoice?->Due_date) }}" id="due_date" placeholder="Due Date">
            {!! $errors->first('Due_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="product" class="form-label">{{ __('Product') }}</label>
            <input type="text" name="product" class="form-control @error('product') is-invalid @enderror" value="{{ old('product', $invoice?->product) }}" id="product" placeholder="Product">
            {!! $errors->first('product', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="section_id" class="form-label">{{ __('Section Id') }}</label>
            <input type="text" name="section_id" class="form-control @error('section_id') is-invalid @enderror" value="{{ old('section_id', $invoice?->section_id) }}" id="section_id" placeholder="Section Id">
            {!! $errors->first('section_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="amount_collection" class="form-label">{{ __('Amount Collection') }}</label>
            <input type="text" name="Amount_collection" class="form-control @error('Amount_collection') is-invalid @enderror" value="{{ old('Amount_collection', $invoice?->Amount_collection) }}" id="amount_collection" placeholder="Amount Collection">
            {!! $errors->first('Amount_collection', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="amount__commission" class="form-label">{{ __('Amount Commission') }}</label>
            <input type="text" name="Amount_Commission" class="form-control @error('Amount_Commission') is-invalid @enderror" value="{{ old('Amount_Commission', $invoice?->Amount_Commission) }}" id="amount__commission" placeholder="Amount Commission">
            {!! $errors->first('Amount_Commission', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="discount" class="form-label">{{ __('Discount') }}</label>
            <input type="text" name="Discount" class="form-control @error('Discount') is-invalid @enderror" value="{{ old('Discount', $invoice?->Discount) }}" id="discount" placeholder="Discount">
            {!! $errors->first('Discount', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="value__v_a_t" class="form-label">{{ __('Value Vat') }}</label>
            <input type="text" name="Value_VAT" class="form-control @error('Value_VAT') is-invalid @enderror" value="{{ old('Value_VAT', $invoice?->Value_VAT) }}" id="value__v_a_t" placeholder="Value Vat">
            {!! $errors->first('Value_VAT', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="rate__v_a_t" class="form-label">{{ __('Rate Vat') }}</label>
            <input type="text" name="Rate_VAT" class="form-control @error('Rate_VAT') is-invalid @enderror" value="{{ old('Rate_VAT', $invoice?->Rate_VAT) }}" id="rate__v_a_t" placeholder="Rate Vat">
            {!! $errors->first('Rate_VAT', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="total" class="form-label">{{ __('Total') }}</label>
            <input type="text" name="Total" class="form-control @error('Total') is-invalid @enderror" value="{{ old('Total', $invoice?->Total) }}" id="total" placeholder="Total">
            {!! $errors->first('Total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <input type="text" name="Status" class="form-control @error('Status') is-invalid @enderror" value="{{ old('Status', $invoice?->Status) }}" id="status" placeholder="Status">
            {!! $errors->first('Status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="value__status" class="form-label">{{ __('Value Status') }}</label>
            <input type="text" name="Value_Status" class="form-control @error('Value_Status') is-invalid @enderror" value="{{ old('Value_Status', $invoice?->Value_Status) }}" id="value__status" placeholder="Value Status">
            {!! $errors->first('Value_Status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="note" class="form-label">{{ __('Note') }}</label>
            <input type="text" name="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note', $invoice?->note) }}" id="note" placeholder="Note">
            {!! $errors->first('note', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="payment__date" class="form-label">{{ __('Payment Date') }}</label>
            <input type="text" name="Payment_Date" class="form-control @error('Payment_Date') is-invalid @enderror" value="{{ old('Payment_Date', $invoice?->Payment_Date) }}" id="payment__date" placeholder="Payment Date">
            {!! $errors->first('Payment_Date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>