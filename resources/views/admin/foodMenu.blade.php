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
                            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Food Management ✨</h1>
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
                                    ><svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>&nbsp; Add Food / Drinks / Pastries</button>
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
                                                    <div class="font-semibold text-slate-800">Add a Meal</div>
                                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                        <div class="sr-only">Close</div>
                                                        <svg class="w-4 h-4 fill-current">
                                                            <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Modal content -->
                                            <form action="{{ route('food.create') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="px-5 py-4">
                                                    <div class="text-sm">
                                                        <div class="font-medium text-slate-800 mb-3">Add meals and group them into categories 🙌</div>
                                                    </div>
                                                    <div class="space-y-3">
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                                                            <input id="name" class="form-input w-full px-2 py-1" type="text" name="name" placeholder="Eg: Abacha / Fried Rice" required />
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="feedback">Description <span class="text-rose-500">*</span></label>
                                                            <textarea id="feedback" class="form-textarea w-full px-2 py-1" name="description" placeholder="A little bit about the food" rows="4" required></textarea>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="name">Price <span class="text-rose-500">*</span></label>
                                                            <input id="name" class="form-input w-full px-2 py-1" type="number" name="price" min="0" placeholder="Just a number" required />
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="name">Discount Price <span class="text-rose-500">*</span></label>
                                                            <input id="name" class="form-input w-full px-2 py-1" type="number" min="0" name="discount" placeholder="Write a number" />
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="name">Category <span class="text-rose-500">*</span></label>
                                                            <select class="block text-sm font-medium mb-1" name="category" for="card-expiry" required onchange="yesnoCheck(this);">Category <span class="text-rose-500" required >*</span>
                                                                <option value="">Select a Category</option>
                                                                @foreach ($data as $category)
                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium mb-1" for="icon">Food Images <span class="text-rose-500">*</span></label>
                                                            <input id="icon" name="images" class="form-input w-full px-2 py-1" type="file" accept="image/*"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="px-5 py-4 border-t border-slate-200">
                                                    <div class="flex flex-wrap justify-end space-x-2">
                                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">Cancel</button>
                                                        <button name="submit" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Add New Meal</button>
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

                    <!-- Cards 1 (Video Courses) -->
                    <div class="mt-8">
                        <div class="grid grid-cols-12 gap-6">
                            <!-- Card 1 -->
                            @foreach ($food as $food)
                                <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-sm border border-slate-200 overflow-hidden">
                                    <div class="flex flex-col h-full">
                                        <!-- Image -->
                                        <img class="w-full" src="food/{{ $food->image }}" width="286" height="160" alt="Application 01" />
                                        <!-- Card Content -->
                                        <div class="grow flex flex-col p-5">
                                            <!-- Card body -->
                                            <div class="grow">
                                                <!-- Header -->
                                                <header class="mb-3">
                                                    <h3 class="text-lg text-slate-800 font-semibold">{{ $food->title }}</h3>
                                                </header>
                                                <!-- Rating and price -->
                                                <div class="flex flex-wrap justify-between items-center mb-4">
                                                    <!-- Price -->
                                                    <div>
                                                        <div class="inline-flex text-sm font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2 py-0.5">₦{{ $food->price }}</div>
                                                    </div>
                                                    <!-- Price -->
                                                    <div>
                                                        <div class="inline-flex text-sm font-medium bg-rose-100 text-rose-600 rounded-full text-center px-2 py-0.5"><s>₦{{ $food->discount_price }}</s></div>
                                                    </div>
                                                </div>
                                                <!-- Features list -->
                                                <ul class="text-sm space-y-2 mb-5">
                                                    <li class="flex items-center">
                                                        <div>{{ $food->description }}</div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Card footer -->
                                            <div>
                                                <!-- Start -->
                                                <div x-data="{ modalOpen: false }">
                                                    <button
                                                        class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white"
                                                        @click.prevent="modalOpen = true"
                                                        aria-controls="feedback-modal"
                                                    >Edit Food / Drinks / Pastries</button>
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
                                                                    <div class="font-semibold text-slate-800">Edit {{ $food->title }}</div>
                                                                    <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                                                                        <div class="sr-only">Close</div>
                                                                        <svg class="w-4 h-4 fill-current">
                                                                            <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <!-- Modal content -->
                                                            <form action="{{ route('food.edit', $food->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="px-5 py-4">
                                                                    <div class="text-sm">
                                                                        <div class="font-medium text-slate-800 mb-3">Make Changes to {{ $food->title }} 🙌</div>
                                                                    </div>
                                                                    <div class="space-y-3">
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                                                                            <input id="name" class="form-input w-full px-2 py-1" type="text" name="name" value="{{ $food->title }}" autofocus />
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="feedback">Description <span class="text-rose-500">*</span></label>
                                                                            <textarea id="feedback" class="form-textarea w-full px-2 py-1" name="description" rows="4" >{{ $food->description }}</textarea>
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="name">Price <span class="text-rose-500">*</span></label>
                                                                            <input id="name" class="form-input w-full px-2 py-1" type="number" name="price" value="{{ $food->price }}" min="0" placeholder="Just a number" />
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="name">Discount Price <span class="text-rose-500">*</span></label>
                                                                            <input id="name" class="form-input w-full px-2 py-1" value="{{ $food->discount_price }}" type="number" min="0" name="discount" placeholder="Write a number" />
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="name">Category <span class="text-rose-500">*</span></label>
                                                                            <select class="block text-sm font-medium mb-1" name="category" for="card-expiry" required onchange="yesnoCheck(this);">Category <span class="text-rose-500" required >*</span>
                                                                                <option value="">Select a Category</option>
                                                                                @foreach ($data as $category)
                                                                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium mb-1" for="icon">Food Image <span class="text-rose-500">*</span></label>
                                                                            <div style="margin-left: 10px; margin-bottom: 10px;">
                                                                                <img src="food/{{ $food->image }}" alt="{{ $food->title }}" width="60" height="60">
                                                                            </div>
                                                                            <input id="icon" name="images" class="form-input w-full px-2 py-1" type="file" accept="image/*"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal footer -->
                                                                <div class="px-5 py-4 border-t border-slate-200">
                                                                    <div class="flex flex-wrap justify-end space-x-2">
                                                                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click="modalOpen = false">Cancel</button>
                                                                        <button name="submit" class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Edit {{ $food->title }}</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End -->
                                            </div>
                                            <div class="py-0.5">
                                                <form action="{{ route('food.delete', $food->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn-sm w-full bg-rose-500 hover:bg-rose-600 text-white" name="submit" type="submit">Delete Food / Drinks / Pastries</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
                            <ul class="flex justify-center">
                                <li class="ml-3 first:ml-0">
                                    <a class="btn bg-white border-slate-200 text-slate-300 cursor-not-allowed" href="#0" disabled>&lt;- Previous</a>
                                </li>
                                <li class="ml-3 first:ml-0">
                                    <a class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500" href="#0">Next -&gt;</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="text-sm text-slate-500 text-center sm:text-left">
                            Showing <span class="font-medium text-slate-600">1</span> to <span class="font-medium text-slate-600">10</span> of <span class="font-medium text-slate-600">467</span> results
                        </div>
                    </div>

                </div>
            </main>

        </div>

    </div>

    @include('admin.partials.footer')
