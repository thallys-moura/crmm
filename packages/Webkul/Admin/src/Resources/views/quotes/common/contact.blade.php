{!! view_render_event('admin.quotes.create.contact_person.form_controls.before') !!}

<v-contact-component
    :data="{{ json_encode(isset($person) ? (is_array($person) ? (object) $person : $person) : (object) []) }}"
></v-contact-component>

{!! view_render_event('admin.quotes.create.contact_person.form_controls.after') !!}
@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-contact-component-template"
    >
            <div class="grid w-full">

                <!-- Person Name -->
                <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.quotes.common.contact.name')
                        </x-admin::form.control-group.label>
                        <div class="flex gap-4">
                            <x-admin::form.control-group.control
                                type="text"
                                id="name"
                                name="person[name]"
                                value="{{ old('person.name', (isset($person) && is_array($person)) ? $person['name'] : $person->name ?? '') }}"
                                label="Person"
                            />
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="hidden" name="raca" value="0">

                                <input
                                    type="checkbox"
                                    name="raca"
                                    id="raca"
                                    class="peer sr-only"
                                    value="1"
                                    {{ old('raca', $person->raca ?? false) ? 'checked' : '' }}
                                >

                                <div class="peer h-5 w-9 cursor-pointer rounded-full bg-gray-200 after:absolute after:top-0 after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-blue-300 dark:bg-gray-800 dark:after:border-white dark:after:bg-white dark:peer-checked:bg-gray-950 after:ltr:left-0.5 peer-checked:after:ltr:translate-x-full after:rtl:right-0.5 peer-checked:after:rtl:-translate-x-full"></div>
                                <span class="ml-2 text-sm font-medium text-gray-900" style="margin-left: 5px;"> Espano?</span>
                            </label>
                        </div>
                </x-admin::form.control-group>

                <!-- Person Email -->
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>
                        @lang('admin::app.quotes.common.contact.email')
                    </x-admin::form.control-group.label>
                    <div class="flex gap-4">

                        <x-admin::attributes.edit.email />

                        <v-email-component
                            :attribute="{'code': 'person[emails]', 'name': 'Email'}"
                            :value='@json(old("person.emails", (isset($person) && is_array($person)) ? $person['emails'] : $person->emails ?? ''))'
                            :hide-fields="true"
                        ></v-email-component>
                    </div>
                </x-admin::form.control-group>


                <!-- Person Contact Numbers -->
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('admin::app.quotes.common.contact.contact-number')
                    </x-admin::form.control-group.label>
                    <div class="flex gap-1">
                        <x-admin::attributes.edit.phone />

                        <v-phone-component
                            :attribute="{'code': 'person[contact_numbers]', 'name': 'Contact Numbers', 'type': 'phone'}"
                            :value='@json(old("person.contact_numbers", (isset($person) && is_array($person)) ? $person['contact_numbers'] : $person->contact_numbers ?? []))'
                            validations="required"
                            :hide-fields="true"
                        ></v-phone-component>
                    </div>
                </x-admin::form.control-group>
    </div>
    </script>

    <script type="module">
        app.component('v-contact-component', {
            template: '#v-contact-component-template',

            props: ['data'],

            data: function () {
                return {
                    is_searching: false,

                    person: this.data && Object.keys(this.data).length > 0 ? this.data : {
                        'name': '',
                        'emails': [{ value: '' }],
                        'contact_numbers': [{ value: '' }],
                        'raca': false
                    },

                    persons: [],
                }
            },

            computed: {
                src() {},

                params() {
                    return {
                        params: {
                            query: this.person['name']
                        }
                    }
                }
            },

            methods: {

            },

            mounted() {

            }
        });
    </script>
@endPushOnce
