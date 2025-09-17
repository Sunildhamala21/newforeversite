<x-layouts.mail :message="$message">
    <x-slot:heading>New enquiry</x-slot>
    <x-slot:body>
        <p style="color:white; margin-bottom: 0;">You have received a new enquiry on
            {{ $enquiry->created_at->timezone('Asia/Kathmandu')->toDayDateTimeString() }}.
        </p>
    </x-slot>
    <table class="data">
        <tr>
            <td colspan="2">
                <p>Name</p>
                <p class="d">{{ $enquiry->name }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p>Country</p>
                <p class="d">{{ $enquiry->country }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Email</p>
                <p class="d">{{ $enquiry->email }}</p>
            </td>
            <td>
                <p>Phone</p>
                <p class="d">{{ $enquiry->phone }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p>Message</p>
                <p class="d">{{ $enquiry->message }}</p>
            </td>
        </tr>
    </table>
</x-layouts.mail>
