<transition name="slide-sidebar">
        <div
            ref="sidebar"
            id="sidebar"
            v-if="isSmallScreen ? isMenuActive : true"
            :class="[
                'fixed top-[60px] z-[10002] h-full border-r border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-gray-900',
                isSmallScreen ? 'w-[200px]' : (isMenuActive ? 'w-[200px]' : 'w-[70px] sidebar-collapsed')
            ]"
            @mouseover="handleMouseOver"
            @mouseleave="handleMouseLeave"
        >
        <div class="journal-scroll h-[calc(100vh-100px)] overflow-hidden group-[.sidebar-collapsed]/container:overflow-visible">
            <nav class="sidebar-rounded grid w-full gap-2">
                @foreach (menu()->getItems('admin') as $menuItem)
                    @php
                        $shouldShowSubmenu = $menuItem->haveChildren() && $menuItem->getKey() !== 'settings';
                    @endphp
                    <div class="px-4 group/item {{ $menuItem->isActive() ? 'active' : 'inactive' }}">
                        <a
                            class="flex gap-2 p-1.5 items-center cursor-pointer hover:rounded-lg {{ $menuItem->isActive() ? 'bg-brandColor rounded-lg' : 'hover:bg-gray-100 hover:dark:bg-gray-950' }} peer"
                            href="{{ (! in_array($menuItem->getKey(), ['settings', 'configuration']) && $shouldShowSubmenu) ? 'javascript:void(0)' : $menuItem->getUrl() }}"
                            @click="onMenuItemClick($event, '{{ $menuItem->getKey() }}', @json($shouldShowSubmenu))"
                        >
                            <span class="{{ $menuItem->getIcon() }} text-2xl {{ $menuItem->isActive() ? 'text-white' : '' }}"></span>
                            
                            <div
                                class="flex-1 flex justify-between items-center font-medium whitespace-nowrap {{ $menuItem->isActive() ? 'text-white' : 'text-gray-600 dark:text-gray-300' }}"
                                :class="{'group-[.sidebar-collapsed]/container:hidden': !isMenuActive && !isSmallScreen}"
                            >
                                <p>{{ $menuItem->getName() }}</p>
                                
                                @if ($shouldShowSubmenu)
                                    <i
                                        class="text-2xl {{ $menuItem->isActive() ? 'text-white' : '' }}"
                                        :class="(isSmallScreen && activeSubmenu === '{{ $menuItem->getKey() }}') ? 'icon-up-arrow' : 'icon-down-arrow rtl:icon-left-arrow'"
                                    ></i>
                                @endif
                            </div>
                        </a>

                        @if ($shouldShowSubmenu)
                            <!-- Submenu para telas pequenas -->
                            <transition name="slide-down">
                                <div
                                    v-if="isSmallScreen && activeSubmenu === '{{ $menuItem->getKey() }}'"
                                    class="flex flex-col bg-gray-100 dark:bg-gray-900"
                                >
                                    <div class="sidebar-rounded min-w-[140px] max-w-max pt-4">
                                        <div class="journal-scroll overflow-hidden">
                                            <nav class="grid w-full gap-2">
                                                @foreach ($menuItem->getChildren() as $subMenuItem)
                                                    <div class="px-4 group/item {{ $subMenuItem->isActive() ? 'active' : 'inactive' }}">
                                                        <a
                                                            href="{{ $subMenuItem->getUrl() }}"
                                                            class="flex gap-2.5 p-2 items-center cursor-pointer hover:rounded-lg {{ $subMenuItem->isActive() ? 'bg-brandColor rounded-lg text-white' : 'hover:bg-gray-100 hover:dark:bg-gray-950 text-gray-600 dark:text-gray-300' }} peer"
                                                        >
                                                            <p class="font-medium whitespace-nowrap">
                                                                {{ $subMenuItem->getName() }}
                                                            </p>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </transition>

                            <!-- Submenu para telas grandes (controlado por clique) -->
                            <transition name="slide-down">
                                <div
                                    v-if="!isSmallScreen && isMenuActive && activeSubmenu === '{{ $menuItem->getKey() }}'"
                                    class="absolute top-0 flex-col bg-gray-100 ltr:left-[200px] rtl:right-[200px]"
                                >
                                    <div class="sidebar-rounded fixed z-[1000] h-full min-w-[140px] max-w-max border-r bg-white pt-4 after:-right-[30px] dark:border-gray-800 dark:bg-gray-900 max-lg:hidden">
                                        <div class="journal-scroll h-[calc(100vh-100px)] overflow-hidden">
                                            <nav class="grid w-full gap-2">
                                                @foreach ($menuItem->getChildren() as $subMenuItem)
                                                    <div class="px-4 group/item {{ $subMenuItem->isActive() ? 'active' : 'inactive' }}">
                                                        <a
                                                            href="{{ $subMenuItem->getUrl() }}"
                                                            class="flex gap-2.5 p-2 items-center cursor-pointer hover:rounded-lg {{ $subMenuItem->isActive() == 'active' ? 'bg-brandColor rounded-lg text-white' : 'hover:bg-gray-100 hover:dark:bg-gray-950 text-gray-600 dark:text-gray-300' }} peer"
                                                        >
                                                            <p class="font-medium whitespace-nowrap">
                                                                {{ $subMenuItem->getName() }}
                                                            </p>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        @endif
                    </div>
                @endforeach
            </nav>
        </div>
    </div>
</transition>
