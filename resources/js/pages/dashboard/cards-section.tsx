import { DollarSign } from 'lucide-react';

import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

interface Metric {
    label: string;
    value: number;
    icon?: React.ReactNode;
}

interface CardProps {
    metric_1: Metric;
    metric_2: Metric;
    metric_3: Metric;
    metric_4?: Metric;
    metric_5?: Metric;
}

export function SectionCards({ metric_1, metric_2, metric_3, metric_4, metric_5 }: CardProps) {
    return (
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>{metric_1.label}</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl"> {metric_1.value} </CardTitle>
                    <div className="absolute top-4 right-4">{metric_1.icon ? metric_1.icon : <DollarSign className="size-3" />}</div>
                </CardHeader>
            </Card>
            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>{metric_2.label}</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl"> {metric_2.value} </CardTitle>
                    <div className="absolute top-4 right-4">{metric_2.icon ? metric_2.icon : <DollarSign className="size-3" />}</div>
                </CardHeader>
            </Card>
            <Card className="@container/card">
                <CardHeader className="relative">
                    <CardDescription>{metric_3.label}</CardDescription>
                    <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl"> {metric_3.value} </CardTitle>
                    <div className="absolute top-4 right-4">{metric_3.icon ? metric_3.icon : <DollarSign className="size-3" />}</div>
                </CardHeader>
            </Card>
            {metric_4 && (
                <Card className="@container/card">
                    <CardHeader className="relative">
                        <CardDescription>{metric_4.label}</CardDescription>
                        <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl"> {metric_4.value} </CardTitle>
                        <div className="absolute top-4 right-4">{metric_4.icon ? metric_4.icon : <DollarSign className="size-3" />}</div>
                    </CardHeader>
                </Card>
            )}
            {metric_5 && (
                <Card className="@container/card">
                    <CardHeader className="relative">
                        <CardDescription>{metric_5.label}</CardDescription>
                        <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl"> {metric_5.value} </CardTitle>
                        <div className="absolute top-4 right-4">{metric_5.icon ? metric_5.icon : <DollarSign className="size-3" />}</div>
                    </CardHeader>
                </Card>
            )}
        </div>
    );
}
