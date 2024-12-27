<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.daily_controls.create.title')
    </x-slot>

    {!! view_render_event('admin.daily_controls.create.form_controls.before') !!}

    <x-admin::form :action="route('admin.daily_controls.store')">
        <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 max-xl:flex-wrap">
            <!-- Header -->
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <div class="flex cursor-pointer items-center">
                        <x-admin::breadcrumbs name="daily_controls.create" />
                    </div>

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::app.daily_controls.create.title')
                    </div>
                </div>

                {!! view_render_event('admin.daily_controls.create.save_button.before') !!}

                <div class="flex items-center gap-x-2.5">
                    <button type="submit" class="primary-button">
                        @lang('admin::app.daily_controls.create.save-btn')
                    </button>
                </div>

                {!! view_render_event('admin.daily_controls.create.save_button.after') !!}
            </div>

            <!-- Form Fields -->
            <div class="grid w-full">
            <div class="flex flex-col gap-1" style="padding: 25px;">
               <div class="w-full" style="width: 50rem;">
                        <!-- Date -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.daily_controls.create.date')
                            </label>
                            <div class="flex gap-4">
                                <input 
                                    type="date" 
                                    name="date" 
                                    class="w-1/3 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" 
                                    required 
                                    value="{{ old('date') }}" 
                                />
                            </div>
                        </div>

                        <!-- User -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.daily_controls.create.user')
                            </label>
                            <div class="flex gap-4">
                                <select name="user_id" class="w-1/2 rounded border custom-select border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required>
                                    <option value="">@lang('admin::app.daily_controls.create.user')</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white">
                                @lang('admin::app.daily_controls.create.calls-made')
                            </label>
                            <div class="flex gap-4">
                                <input 
                                    type="number" 
                                    name="calls_made" 
                                    class="w-1/4 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" 
                                    value="{{ old('calls_made', 0) }}" 
                                />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white">
                                @lang('admin::app.daily_controls.create.leads-count')
                            </label>
                            <div class="flex gap-4">
                                <input 
                                    type="number" 
                                    name="leads_count" 
                                    class="w-1/4 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" 
                                    value="{{ old('leads_count', 0) }}" 
                                />
                            </div>
                        </div>

                        <!-- Sales -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white">
                                @lang('admin::app.daily_controls.create.sales')
                            </label>
                            <div class="flex gap-4">
                                <input 
                                    type="number" 
                                    name="sales" 
                                    class="w-1/4 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" 
                                    value="{{ old('sales', 0) }}" 
                                />
                            </div>
                        </div>

                        <!-- Source -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                                @lang('admin::app.daily_controls.create.source')
                            </label>
                            <div class="flex gap-4">
                                <select name="source_id" class="w-1/2 rounded border custom-select border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required>
                                    <option value="">@lang('admin::app.daily_controls.create.source')</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white required">
                            @lang('admin::app.daily_controls.create.product-group')
                            </label>
                            <div class="flex gap-4">
                                <select name="product_group_id" class="w-1/2 rounded border custom-select border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" required>
                                    <option value="">@lang('admin::app.daily_controls.create.product-group')</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Daily Ad Spending -->
                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white">
                                @lang('admin::app.daily_controls.create.daily-ad-spending')
                            </label>
                            <div class="flex gap-4">
                                <input 
                                    type="text" 
                                    name="daily_ad_spending" 
                                    class="w-1/4 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" 
                                    value="{{ old('daily_ad_spending', '0.00') }}" 
                                />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1.5 flex items-center gap-1 text-sm font-normal text-gray-800 dark:text-white">
                                @lang('admin::app.daily_controls.create.daily-ad-spending')
                            </label>
                            <div class="flex gap-4">
                                <input 
                                    type="text" 
                                    name="total_revenue" 
                                    class="w-1/4 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400" 
                                    value="{{ old('total_revenue', '0.00') }}" 
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.daily_controls.create.form_controls.after') !!}
</x-admin::layouts>
