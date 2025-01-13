import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        refNo: "",
        password: "",
        password_confirmation: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("register"), {
            onFinish: () => reset("password", "password_confirmation"),
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit} className="space-y-4">
                <div>
                    <InputLabel
                        htmlFor="refNo"
                        value="Reference No."
                        required={false}
                    />
                    <TextInput
                        id="refNo"
                        name="refNo"
                        value={data.refNo}
                        placeholder="Enter Reference No, If any"
                        className="mt-1 block w-full"
                        autoComplete="off"
                        onChange={(e) => setData("refNo", e.target.value)}
                        aria-label="Reference Number"
                    />
                </div>
                <div>
                    <InputLabel htmlFor="name" value="Name" required={true} />
                    <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        placeholder="Enter Full Name"
                        className="mt-1 block w-full"
                        autoComplete="name"
                        onChange={(e) =>
                            setData({ ...data, name: e.target.value })
                        }
                        aria-label="Full name"
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>
                <div>
                    <InputLabel htmlFor="email" value="Email" required={true} />
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        placeholder="Enter Email"
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData("email", e.target.value)}
                        aria-label="Email address"
                    />
                    <InputError message={errors.email} className="mt-2" />
                </div>
                <div>
                    <InputLabel
                        htmlFor="password"
                        value="Password"
                        required={true}
                    />
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        placeholder="Enter Password"
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData("password", e.target.value)}
                        aria-label="Password"
                    />
                    <InputError message={errors.password} className="mt-2" />
                </div>
                <div>
                    <InputLabel
                        htmlFor="password_confirmation"
                        value="Confirm Password"
                        required={true}
                    />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        placeholder="Enter Confirm Password"
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                        aria-label="Confirm password"
                    />
                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>
                <div className="flex items-center justify-between space-y-4">
                    <Link
                        href={route("login")}
                        className="text-sm text-gray-600 underline hover:text-gray-900"
                    >
                        Already registered?
                    </Link>
                    <PrimaryButton className="ml-4" disabled={processing}>
                        {processing ? "Processing..." : "Register"}
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
