import {Head, Link, router, usePage} from '@inertiajs/react';
import {useForm} from 'react-hook-form'
import {z} from "zod";
import {zodResolver} from "@hookform/resolvers/zod";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/Components/ui/card";
import {Button} from "@/Components/ui/button";
import {Form, FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/Components/ui/form";
import {Input} from "@/Components/ui/input";
import {useEffect, useState} from "react";
import axios from "axios";

export default function Register() {
    const [state, setState] = useState({
        'serverErrors': '',
    });
    const {errors} = usePage().props

    const registerSchema = z.object({
        name: z.string().min(1, "Name is required").max(255, "Name is too long"),
        email: z.string()
            .min(1, "Email is required")
            .max(255)
            .transform((val) => val.toLowerCase()),
        password: z.string()
            .min(8, 'Must be at least 8 characters long')
            .max(255, "I admire your spunk but that password is too long"),
        password_confirmation: z.string(),
    }).refine((data) => data.password === data.password_confirmation, {
        message: 'Password confirmation must match password',
        path: ["password_confirmation"]
    })

    const form = useForm({
        resolver: zodResolver(registerSchema),
        defaultValues: {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        }
    })

    const checkUniqueEmail = async (e: React.FocusEvent<HTMLInputElement>) => {
        const emailResponse = z.object({
            data: z.object({
                email_not_unique: z.boolean(),
            })
        })

        try {
            const data = await axios.post(route('check.email'), {email: e.target.value});
            const responseObject = emailResponse.parse(data)

            if (responseObject.data.email_not_unique) {
                form.setError('email', {type: 'value', message: 'That email cannot be used'})
            }
        } catch (error) {
            console.log(error)
        }
    }

    const submit = (values: z.infer<typeof registerSchema>) => {
        router.post(route('register'), values);
    }

    useEffect(() => {
        Object.keys(errors).map((error) => {
            const errorShape = z.enum(['name', 'email', 'password', 'password_confirmation'])
            const validError = errorShape.parse(error)

            form.setError(validError, {type: 'value', message: errors[error]})
        })
    }, [errors])

    return (
        <section className="flex justify-center items-center w-full h-svh max-w-screen-sm mx-auto">
            <Head title="Register" />
            <Card className="w-full">
                <Form {...form}>
                    <form onSubmit={form.handleSubmit(submit)}>
                        <CardHeader>
                            <CardTitle>Register for an account!</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {state.serverErrors
                                ? <div>{'Error with submission: ' + state.serverErrors }</div>
                                : ''
                            }
                            <FormField
                                control={form.control}
                                name='name'
                                render={({field}) => {
                                    return <FormItem>
                                        <FormLabel>Name</FormLabel>
                                        <FormControl>
                                            <Input {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                }}
                            />
                            <FormField
                                control={form.control}
                                name='email'
                                render={({field}) => {
                                    return <FormItem>
                                        <FormLabel>Email</FormLabel>
                                        <FormControl>
                                            <Input {...field} onBlur={checkUniqueEmail} />
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
                                            <Input type="password" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                }}
                            />
                            <FormField
                                control={form.control}
                                name='password_confirmation'
                                render={({field}) => {
                                    return <FormItem>
                                        <FormLabel>Password Confirmation</FormLabel>
                                        <FormControl>
                                            <Input type="password" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                }}
                            />
                        </CardContent>
                        <CardFooter>
                            <Button type="submit">Save</Button>
                        </CardFooter>
                    </form>
                </Form>
            </Card>

        </section>
    );
}
