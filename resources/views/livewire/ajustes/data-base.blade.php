<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Base Back-up: 
                <b class="text-danger">
                {{ $currentPath }}
                </b>
            </h4>
            <div class="vtabs customvtab">
                <div class="tab-content">
                    <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                        <div class="table-responsive">
                            <table class="table table-hover">
                              <tbody>
                                @foreach ($files as $file)
                                <tr>
                                    <td>
                                        <i class="fas fa-file-zip-o" style="font-size: 32px;"></i>
                                    </td>
                                    <td>
                                        {{ $file['name'] }}
                                    </td>
                                    <td>
                                        <a href="{{ Storage::disk('s3')->url($file['path']) }}" target="_blank" class="btn btn-sm btn-dark"><i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" wire:click="delete('{{ $file['path'] }}')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
