import ApplicationLogo from "@/Components/ApplicationLogo";
import { Link } from "@inertiajs/react";

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link href="/">
                    <ApplicationLogo
                        src="/images/smart-precure-logo.png"
                        alt="Application Logo"
                        className="fill-current text-gray-500"
                    />
                </Link>
            </div>

            <div className="mt-6 w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-lg sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}
