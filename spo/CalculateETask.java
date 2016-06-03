package bg.uni_sofia.fmi.spo.calculate_E;

import java.util.Calendar;

import org.apfloat.Apfloat;

public class CalculateETask extends Thread {

	private long precision;
	private int begin;
	private int end;
	private boolean quiet;
	public Apfloat sum;
	public Apfloat lastTerm;
	
	public CalculateETask(long precision, int begin, int end , boolean quiet) {
		this.precision = precision;
		this.begin= begin;
		this.end = end;
		this.sum = new Apfloat(0.0, precision);
		this.quiet = quiet;
	}
	
	public void run (){
		long startTime = Calendar.getInstance().getTimeInMillis();
		Apfloat fact = new Apfloat(1.0, precision);
		Apfloat term = new Apfloat(0.0, precision);
		for (int i = 1; i <= 3 * (begin - 1); i++){
			fact = fact.multiply(new Apfloat(i));
		}
		for (int i = begin; i <= end; i++){

			if (i > 0){
				fact = fact.multiply(new Apfloat((3 * i * ( 3 * i - 1) * (3 * i - 2)), precision));
			}
			Apfloat numerator = new Apfloat((9 * i * i + 1), precision);
			term = numerator.divide(fact);
			sum = sum.add(term);
			if (i == end){
				lastTerm = term;
			}
		}

		long endTime = Calendar.getInstance().getTimeInMillis();
        long calculationTime = endTime - startTime;
        if (!quiet){
        	System.out.println("Thread [" + begin + " , " + end + "]: Calculation Time: " + calculationTime);
        }
	}
}
