import GuestLayout from '@/Layouts/GuestLayout';
import {Head, Link, router} from '@inertiajs/react';
import {useForm} from "react-hook-form";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/Components/ui/card";
import {Form, FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage} from "@/Components/ui/form";
import {z} from "zod";
import {zodResolver} from "@hookform/resolvers/zod";
import {Input} from "@/Components/ui/input";
import {Button} from "@/Components/ui/button";

export default function Login({ status, canResetPassword }: { status?: string, canResetPassword: boolean }) {
    const loginSchema = z.object({
        email: z.string().min(1, 'Email is required'),
        password: z.string().min(1, 'Password is required'),
    })

    const form = useForm({
        resolver: zodResolver(loginSchema),
        defaultValues: {
            email: '',
            password: '',
        }
    })

    const submit = (values: z.infer<typeof loginSchema>) => {
        router.post(route('login'), values);
    };

    return (
        <section className="flex justify-center items-center w-full h-svh max-w-screen-sm mx-auto">
            <Head title="Log in" />

            <Card className="w-full">
                <Form {...form}>
                    <form onSubmit={form.handleSubmit(submit)}>
                        <CardHeader>
                            <CardTitle>Log in</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <FormField
                                control={form.control}
                                name='email'
                                render={({field}) => {
                                    return <FormItem>
                                        <FormLabel>Email</FormLabel>
                                        <FormControl>
                                            <Input placeholder="Enter email..." {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                }}
                            />
                            <FormField
                                control={form.control}
                                name='password'
                                render={({field}) => {
                                    return <FormItem>
                                        <FormLabel>Password</FormLabel>
                                        <FormControl>
                                            <Input type="password" placeholder="Enter password..." {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                }}
                            />
                        </CardContent>
                        <CardFooter>
                            <Button type="submit">Login</Button>
                        </CardFooter>
                    </form>
                </Form>
            </Card>
        </section>
    );
}
