<div>
    <div class="card-controls sm:flex my-2">
        <div class="w-full sm:w-1/2">
            Per page:
            <select wire:model="perPage" class="w-20 border-none bg-gray-100 rounded-full text-center shadow-sm hover:bg-blue-100">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            @can('resume_delete')
                <button class="btn btn-rose ml-3 disabled:opacity-50 disabled:cursor-not-allowed" type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}>
                    {{ __('Delete Selected') }}
                </button>
            @endcan

            @if(file_exists(app_path('Http/Livewire/ExcelExport.php')))
                <livewire:excel-export model="Resume" format="csv" />
                <livewire:excel-export model="Resume" format="xlsx" />
                <livewire:excel-export model="Resume" format="pdf" />
            @endif




        </div>
        <div class="w-full sm:w-1/2 sm:text-right">
            Search:
            <input type="text" wire:model.debounce.300ms="search" class=" border-none bg-gray-100 rounded-full text-center shadow-sm hover:bg-blue-100" />
        </div>
    </div>
    <div wire:loading.delay>
        Loading...
    </div>

    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-index w-full bg-white">
                <thead>
                    <tr>
                        <th class="w-9">
                        </th>
                        <th class="w-28">
                            {{ trans('cruds.resume.fields.id') }}
                            @include('components.table.sort', ['field' => 'id'])
                        </th>
                        <th>
                            {{ trans('cruds.resume.fields.title') }}
                            @include('components.table.sort', ['field' => 'title'])
                        </th>
                        <th>
                            {{ trans('cruds.resume.fields.resume') }}
                        </th>
                        <th>
                            {{ trans('cruds.resume.fields.status') }}
                            @include('components.table.sort', ['field' => 'status'])
                        </th>
                        <th>
                            {{ trans('cruds.resume.fields.job') }}
                            @include('components.table.sort', ['field' => 'job.job_title'])
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resumes as $resume)
                        <tr>
                            <td>
                                <input type="checkbox" value="{{ $resume->id }}" wire:model="selected">
                            </td>
                            <td>
                                {{ $resume->id }}
                            </td>
                            <td>
                                {{ $resume->title }}
                            </td>
                            <td>
                                @foreach($resume->resume as $key => $entry)
                                    <a class="link-light-blue" href="{{ $entry['url'] }}">
                                        <i class="far fa-file">
                                        </i>
                                        {{ $entry['file_name'] }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $resume->status_label }}
                            </td>
                            <td>
                                @if($resume->job)
                                    <span class="badge badge-relationship">{{ $resume->job->job_title ?? '' }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    @can('resume_show')
                                        <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.resumes.show', $resume) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('resume_edit')
                                        <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.resumes.edit', $resume) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('resume_delete')
                                        <button class="btn btn-sm btn-rose mr-2" type="button" wire:click="confirm('delete', {{ $resume->id }})" wire:loading.attr="disabled">
                                            {{ trans('global.delete') }}
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">No entries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-body">
        <div class="pt-3">
            @if($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $resumes->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('confirm', e => {
    if (!confirm("{{ trans('global.areYouSure') }}")) {
        return
    }
@this[e.callback](...e.argv)
})
    </script>
@endpush