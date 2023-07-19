@include('admin.partials.head')

<body
    class="font-inter antialiased bg-slate-100 text-slate-600"
    :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
>

    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>

    <!-- Page wrapper -->
    <div class="flex h-screen overflow-hidden">

        @include('admin.partials.sidebar')

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            @include('admin.partials.header')

            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

                    @if (session()->has('message'))

                    <div id="alert-3" class="flex p-4 bg-emerald-500 rounded-lg dark:bg-emerald-600" role="alert">
                        <div class="ml-3 text-sm font-medium text-white dark:text-white">
                          {{ session()->get('message') }}. Move on!
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-emerald-100 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerlad-200 inline-flex h-8 w-8 dark:bg-emerald-200 dark:text-emerald-600 dark:hover:bg-emerald-300" data-dismiss-target="#alert-3" aria-label="Close">
                          <span class="sr-only">Close</span>
                          <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                      </div>

                    @endif

                    <!-- Page header -->
                    <div class="sm:flex sm:justify-between sm:items-center mb-8">

                        <!-- Left: Title -->
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Food Categories ✨</h1>
                        </div>

                        <!-- Right: Actions -->
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                            <!-- Add Category -->
                            <div class="m-1.5">
                                <!-- Start -->
                                <div x-data="{ modalOpen: false }">
                                    <button
                                        class="btn bg-indigo-500 hover:bg-indigo-600 text-white"
                                        @click.prevent="modalOpen = true"
                                        aria-controls="feedback-modal"
                                    >Add Category</button>
                                    <!-- Modal backdrop -->
                                    <div
                                        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                        x-show="modalOpen"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-out duration-100"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        aria-hidden="true"
                                        x-cloak
                                    ></div>
                                    <!-- Modal dialog -->
                                    <div
                                        id="feedback-modal"
                                        class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                        role="dialog"
                                        aria-modal="true"
                                        x-show="modalOpen"
                                        x-transition:enter="transition ease-in-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in-out duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        x-cloak
                                    >
                                        <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                            <!-- Modal header -->
                                            <div class="px-5 py-3 border-b border-slate-200">
                                                <div class="flex justify-between items-center">
                                                    <div class="font-semibold text-slate-800">Add a Food Category</div>
                                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                        <div class="sr-only">Close</div>
                                                        <svg class="w-4 h-4 fill-current">
                                                            <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Modal content -->
                                            <form action="{{ route('category.create') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="px-5 py-4">
                                                    <div class="text-sm">
                                                        <div class="font-medium text-slate-800 mb-3">Grouping dishes into categories makes life easier 🙌</div>
                                                    </div>
                                                    <div class="space-y-3">
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="name">Category Name <span class="text-rose-500">*</span></label>
                                                            <input id="name" class="form-input w-full px-2 py-1" type="text" name="name" placeholder="Eg: Salads / Drinks / Native Cuisine" required />
                                                            @if ($errors->has('name'))
                                                                <span style="color: red; font-size: 12px;">{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="icon">Icon <span class="text-rose-500">*</span></label>
                                                            <input id="icon" name="icon" class="form-input w-full px-2 py-1" type="file" placeholder="Upload image for Asethetics " required/>
                                                            @if ($errors->has('icon'))
                                                                <span style="color:red; font-size: 12px;">{{ $errors->first('icon') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="px-5 py-4 border-t border-slate-200">
                                                    <div class="flex flex-wrap justify-end space-x-2">
                                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">Cancel</button>
                                                        <button name="submit" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Add New Category</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End -->
                            </div>

                        </div>

                    </div>

                    <!-- Cards -->
                    <div class="grid grid-cols-12 gap-6">

                        <!-- Category Card -->
                        @foreach ($data as $category)
                            <div class="col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
                                <div class="flex flex-col h-full">
                                    <!-- Card top -->
                                    <div class="grow p-5">
                                        <div class="flex justify-between items-start">
                                            <!-- Image + name -->
                                            <header>
                                                <div class="flex mb-2">
                                                    <a class="relative inline-flex items-start mr-5" href="#0">
                                                        <img class="rounded-full" src="/categoryIcons/{{ $category->icon }}" width="64" height="64" alt="#" />
                                                    </a>
                                                    <div class="mt-1 pr-1">
                                                        <a class="inline-flex text-slate-800 hover:text-slate-900" href="#0">
                                                            <h2 class="text-xl leading-snug justify-center font-semibold">{{ $category->name }}</h2>
                                                        </a>
                                                    </div>
                                                </div>
                                            </header>
                                        </div>
                                    </div>
                                    <!-- Card footer -->
                                    <div class="border-t border-slate-200">
                                        <div class="flex divide-x divide-slate-200r">
                                            <div class="m-1.5" style="margin: 12px 50px; ">
                                                <!-- Start -->
                                                <div x-data="{ modalOpen: false }">
                                                    <button
                                                        class="btn text-slate-800"
                                                        @click.prevent="modalOpen = true"
                                                        aria-controls="feedback-modal"
                                                    ><svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-slate-500 shrink-0 mr-2" viewBox="0 0 16 16">
                                                        <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                                    </svg>
                                                    Edit Category</button>
                                                    <!-- Modal backdrop -->
                                                    <div
                                                        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                        x-show="modalOpen"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease-out duration-100"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0"
                                                        aria-hidden="true"
                                                        x-cloak
                                                    ></div>
                                                    <!-- Modal dialog -->
                                                    <div
                                                        id="feedback-modal"
                                                        class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                        role="dialog"
                                                        aria-modal="true"
                                                        x-show="modalOpen"
                                                        x-transition:enter="transition ease-in-out duration-200"
                                                        x-transition:enter-start="opacity-0 translate-y-4"
                                                        x-transition:enter-end="opacity-100 translate-y-0"
                                                        x-transition:leave="transition ease-in-out duration-200"
                                                        x-transition:leave-start="opacity-100 translate-y-0"
                                                        x-transition:leave-end="opacity-0 translate-y-4"
                                                        x-cloak
                                                    >
                                                        <div class="bg-white rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                                                            <!-- Modal header -->
                                                            <div class="px-5 py-3 border-b border-slate-200">
                                                                <div class="flex justify-between items-center">
                                                                    <div class="font-semibold text-slate-800">Edit Food Category</div>
                                                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                                        <div class="sr-only">Close</div>
                                                                        <svg class="w-4 h-4 fill-current">
                                                                            <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <!-- Modal content -->
                                                            <form action="{{ route('category.edit', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="px-5 py-4">
                                                                    <div class="text-sm">
                                                                        <div class="font-medium text-slate-800 mb-3">Grouping dishes into categories makes life easier 🙌</div>
                                                                    </div>
                                                                    <div class="space-y-3">
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="name">Category Name <span class="text-rose-500">*</span></label>
                                                                            <input id="name" class="form-input w-full px-2 py-1" name="name" type="text" value="{{ $category->name }}" placeholder="Eg: Salads / Drinks / Native Cuisine" required />
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="icon">Icon <span class="text-rose-500">*</span></label>
                                                                            <input id="icon" name="icon" class="form-input w-full px-2 py-1" type="file" value="{{ $category->icon }}" placeholder="Upload image for Asethetics " required/>
                                                                            @if ($errors->has('icon'))
                                                                                <span style="color:red;">{{ $errors->first('icon') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal footer -->
                                                                <div class="px-5 py-4 border-t border-slate-200">
                                                                    <div class="flex flex-wrap justify-end space-x-2">
                                                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">Cancel</button>
                                                                        <button name="submit" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Edit Category</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End -->
                                            </div>
                                            <form action="{{ route('category.delete', $category->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="block flex-1 text-center text-sm text-rose-500 hover:text-rose-600 font-medium px-3 py-4 group">
                                                    <div class="flex items-center justify-center">
                                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                            <path d="M13 15h2v6h-2zM17 15h2v6h-2z"></path>
                                                            <path d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z"></path>
                                                        </svg>
                                                        <span>Delete Category</span>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>

            </main>

        </div>

    </div>

    @include('admin.partials.footer')
