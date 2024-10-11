<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Explorador de archivos Bucket S3: 
                <b class="text-danger">
                {{ $currentPath }}
                {{-- {{ explode("/", $currentPath) }} --}}
                {{-- @foreach ($dir_url as $url => $val)
                    <a href="#" wire:click="selectDirectory('{{ $val }}')">{{ $val }}</a>
                @endforeach --}}
                </b>
            </h4>
            <div class="vtabs customvtab">
                <ul class="nav nav-tabs tabs-vertical" role="tablist">
                    <li>
                         <button class="btn btn-link" wire:click="selectDirectory('/')">
                            <i class="fas fa-folder-open"></i>
                            Inicio
                        </button>
                    </li>
                @foreach ($base_directories as $dir)
                @if ( basename($dir) != 'Mis-Beneficios-Vacacionales')
                    <li class="">
                        <button class="btn btn-link" wire:click="selectDirectory('{{ basename($dir) }}')">
                            <i class="fas fa-folder-open"></i>
                            {{ basename($dir) }}
                        </button>
                    </li>
                @endif
                @endforeach
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                        <ul class="nav" role="tablist">
                        @foreach ($directories as $directory)
                        @if ($directory['path'] != 'Mis-Beneficios-Vacacionales')
                            <li class="">
                                <button class="btn btn-link" wire:click="selectDirectory('{{ $directory['path'] }}')">
                                    <i class="fas fa-folder-open"></i>
                                    {{ $directory['name'] }}
                                </button>
                            </li>
                        @endif
                        @endforeach
                        </ul>
                        <div class="row"> 
                        @foreach ($files as $file)
                        <div class="col-lg col-md-6">
                            <div class="card p-10 text-center">
                                <div class="el-card-item">
                                    <div class="el-card-avatar">   
                                        {{-- <img src="{{ asset($file['path']) }}" class="img-fluid" alt=""> --}}
                                        @php
                                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                                        $extensiones_validas = ['jpg', 'jpeg', 'png', 'gif','ico'];
                                        @endphp
                                        @if (in_array(strtolower($extension), $extensiones_validas))
                                            <img src="{{ Storage::disk('s3')->url($file['path']) }}" class="img-fluid" alt="">
                                        @else
                                            <a href="{{ Storage::disk('s3')->url($file['path']) }}" target="_blank">
                                                <i class="fas fa-file" style="font-size: 48px;"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="el-card-content">
                                        <p class="box-title">
                                            {{ $file['name'] }}
                                        </p> 
                                        <a href="{{ Storage::disk('s3')->url($file['path']) }}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-sm btn-danger" wire:click="delete('{{ $file['path'] }}')"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md p-20 text-center">
                            @php
                            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                            $extensiones_validas = ['jpg', 'jpeg', 'png', 'gif','ico'];
                            @endphp
                            @if (in_array(strtolower($extension), $extensiones_validas))
                                <img src="{{ asset($file['path']) }}" class="img-fluid" alt="">
                            @else
                                <i class="fas fa-file" style="font-size: 48px;"></i>
                            @endif
                            {{ $file['name'] }}
                            <br>
                            <div class="mt-2 text-center">
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </div>
                        </div> --}}
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
