'use client';

import * as React from 'react';
import { Label, Pie, PieChart, Sector } from 'recharts';
import { PieSectorDataItem } from 'recharts/types/polar/Pie';

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ChartConfig, ChartContainer, ChartStyle, ChartTooltip, ChartTooltipContent } from '@/components/ui/chart';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

export const description = 'An interactive pie chart';

const exampleData = [
    { label: 'january', value: 186, fill: 'var(--color-january)' },
    { label: 'february', value: 305, fill: 'var(--color-february)' },
    { label: 'march', value: 237, fill: 'var(--color-march)' },
    { label: 'april', value: 173, fill: 'var(--color-april)' },
    { label: 'may', value: 209, fill: 'var(--color-may)' },
];

const chartConfig = {
    visitors: {
        label: 'Hours',
    },
    value: {
        label: 'Desktop',
    },
    mobile: {
        label: 'Mobile',
    },
    january: {
        label: 'January',
        color: 'var(--chart-1)',
    },
    february: {
        label: 'February',
        color: 'var(--chart-2)',
    },
    march: {
        label: 'March',
        color: 'var(--chart-3)',
    },
    april: {
        label: 'April',
        color: 'var(--chart-4)',
    },
    may: {
        label: 'May',
        color: 'var(--chart-5)',
    },
} satisfies ChartConfig;

export function ChartPieInteractive({ pieData = exampleData, startDate, endDate, label }) {
    const id = 'pie-interactive';
    const [activeLabel, setActiveLabel] = React.useState(pieData[0].label);
    console.log('Pie Data:', pieData);
    const activeIndex = React.useMemo(() => pieData.findIndex((item) => item.label === activeLabel), [activeLabel]);
    const months = React.useMemo(() => pieData.map((item) => item.label), []);
    const newChartConfig = pieData.reduce((acc, item, index) => {
        acc[item.label] = {
            label: item.label,
            color: `var(--chart-${index + 1})`,
        };
        return acc;
    }, {} as ChartConfig);
    return (
        <Card data-chart={id} className="flex flex-col">
            <ChartStyle id={id} config={chartConfig} />
            <CardHeader className="flex-row items-start space-y-0 pb-0">
                <div className="grid gap-1">
                    <CardTitle>{label}</CardTitle>
                    <CardDescription>
                        {startDate} - {endDate}
                    </CardDescription>
                </div>
                <Select value={activeLabel} onValueChange={setActiveLabel}>
                    <SelectTrigger className="ml-auto h-7 w-[250px] rounded-lg pl-2.5" aria-label="Select a value">
                        <SelectValue placeholder="Select label" />
                    </SelectTrigger>
                    <SelectContent align="end" className="rounded-xl">
                        {months.map((key) => {
                            const config = newChartConfig[key as keyof typeof newChartConfig];

                            if (!config) {
                                return null;
                            }

                            return (
                                <SelectItem key={key} value={key} className="rounded-lg [&_span]:flex">
                                    <div className="flex items-center gap-2 text-xs">
                                        <span
                                            className="flex h-3 w-3 shrink-0 rounded-xs"
                                            style={{
                                                backgroundColor: `var(--color-${key})`,
                                            }}
                                        />
                                        {config?.label}
                                    </div>
                                </SelectItem>
                            );
                        })}
                    </SelectContent>
                </Select>
            </CardHeader>
            <CardContent className="flex flex-1 justify-center pb-0">
                <ChartContainer id={id} config={chartConfig} className="mx-auto aspect-square w-full max-w-[300px]">
                    <PieChart>
                        <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
                        <Pie
                            data={pieData}
                            dataKey="value"
                            nameKey="label"
                            innerRadius={60}
                            strokeWidth={5}
                            activeIndex={activeIndex}
                            activeShape={({ outerRadius = 0, ...props }: PieSectorDataItem) => (
                                <g>
                                    <Sector {...props} outerRadius={outerRadius + 10} />
                                    <Sector {...props} outerRadius={outerRadius + 25} innerRadius={outerRadius + 12} />
                                </g>
                            )}
                        >
                            <Label
                                content={({ viewBox }) => {
                                    if (viewBox && 'cx' in viewBox && 'cy' in viewBox) {
                                        return (
                                            <text x={viewBox.cx} y={viewBox.cy} textAnchor="middle" dominantBaseline="middle">
                                                <tspan x={viewBox.cx} y={viewBox.cy} className="fill-foreground text-3xl font-bold">
                                                    {pieData[activeIndex].value.toLocaleString()}
                                                </tspan>
                                                <tspan x={viewBox.cx} y={(viewBox.cy || 0) + 24} className="fill-muted-foreground">
                                                    Hours
                                                </tspan>
                                            </text>
                                        );
                                    }
                                }}
                            />
                        </Pie>
                    </PieChart>
                </ChartContainer>
            </CardContent>
        </Card>
    );
}
