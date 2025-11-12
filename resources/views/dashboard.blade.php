@include("./includes/header")
@include('./includes/sidebar')
<div class="p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
<div class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Top Navbar -->
    <!-- Main Content -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r hidden md:block">
            <div class="p-4 space-y-2">
                <a href="#" class="block py-2 px-3 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <i class="mr-2">🏠</i> Dashboard
                </a>
                <a href="#" class="block py-2 px-3 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <i class="mr-2">📁</i> My Folders
                </a>
                <a href="#" class="block py-2 px-3 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <i class="mr-2">📄</i> All Documents
                </a>
                <a href="#" class="block py-2 px-3 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <i class="mr-2">👥</i> Users
                </a>
                <a href="#" class="block py-2 px-3 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <i class="mr-2">⚙️</i> Settings
                </a>
            </div>
        </aside>

        <!-- Dashboard Body -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Folder Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-500 text-sm">Total Folders</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">36</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-500 text-sm">Shared Documents</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">128</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-500 text-sm">Users</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">12</p>
                </div>
            </div>

            <!-- Recent Documents -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-4 border-b flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Recent Documents</h2>
                    <a href="#" class="text-blue-600 text-sm hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folder</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">Finance_Report_Q3.pdf</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Finance</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Robel Kidane</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Nov 3, 2025</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <button class="text-blue-600 hover:underline">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">Staff_List.xlsx</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">HR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Yohannes</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">Oct 29, 2025</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <button class="text-blue-600 hover:underline">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
   </div>
</div>
@include('./includes/footer')