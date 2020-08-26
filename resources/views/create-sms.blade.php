<div class="row"><div class="col-md-12">
    <div class="box box-info">
    <div class="box-header with-border">
    <h3 class="box-title">Create</h3>
    <div class="box-tools">
    <div class="btn-group pull-right" style="margin-right: 5px">
    <a href="/admin/sms" class="btn btn-sm btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;List</span></a>
    </div>
    </div>
    </div>
    
    <form action="{{route('sendsms')}}" method="post" class="form-horizontal" accept-charset="UTF-8" pjax-container="">
    
    {{ csrf_field() }}
    
    <div class="box-body">
    <div class="fields-group">
    
    <div class="col-md-12">
    
    <div class="form-group">
    <label for="phone" class="col-sm-2 asterisk control-label">Phone</label>
    <div class="col-sm-8">
    <div class="input-group">
    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
    <input type="text" id="phone" name="phone" value="" class="form-control phone" placeholder="Phone Number" required>
    </div>
    </div>
    </div>
    
    <div class="form-group">
    <label for="data" class="col-sm-2 asterisk control-label">Message</label>
    <div class="col-sm-8">
    <textarea id="message" name="message" class="form-control data" rows="5" placeholder="Message" required></textarea>
    </div>
    </div>
    
    </div>
    </div>
    </div>
    
    <div class="box-footer">
    <div class="col-md-2">
    </div>
    
    <div class="col-md-8">
    <div class="btn-group pull-right">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    
    </div>
    </div>
    </form>
    </div>
    </div>
    </div>