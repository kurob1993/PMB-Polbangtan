<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Informasi Pendaftaran</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<form id="informasi_pendaftaran" class="form-horizontal form-label-left">
				<div class="form-group">
					<label class="control-label col-sm-2">Jalur Pendaftaran</label>
					<div class="col-sm-9">
						<input type="text" id="nama" class="form-control" value="{{ $data->jalur_label }}" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Tanggal Mendaftar</label>
					<div class="col-sm-9">
						<input type="text" id="nama" class="form-control" value="{{ $data->created_at }}" readonly>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
	Informasi Dokumen Jalur
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
	Informasi Institusi dan Jurusan
</div>
