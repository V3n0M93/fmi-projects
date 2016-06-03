package bg.uni_sofia.fmi.spo.calculate_E;

import org.apache.commons.cli.CommandLine;
import org.apache.commons.cli.CommandLineParser;
import org.apache.commons.cli.DefaultParser;
import org.apache.commons.cli.Options;
import org.apache.commons.cli.ParseException;

public class Main {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
	
		CommandLineParser parse = new DefaultParser();
		Options options = new Options();
		
		options.addOption("p", true, "Precision");
		options.addOption("t", "tasks", true, "Threads");
		options.addOption("o", true, "File");
		options.addOption("q", false, "Quiet");
		
		try {
			CommandLine commandLine = parse.parse(options, args);
			int precision = 1000;
			int tasks = 1;
			String file = new String("result.txt");
			boolean quiet = false;
			String parameter;
			if(commandLine.hasOption("p")){
				parameter = commandLine.getOptionValue("p");
				precision = Integer.valueOf(parameter);
			}
			
			if(commandLine.hasOption("t")){
				parameter = commandLine.getOptionValue("t");
				tasks = Integer.valueOf(parameter);
			}
			
			if(commandLine.hasOption("o")){
				file = commandLine.getOptionValue("o");
			}
			
			if(commandLine.hasOption("q")){
				quiet = true;
			}
			
			CalculateE calculator = new CalculateE();
			calculator.calculate(precision, tasks, file, quiet);
			
		} catch (ParseException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		
		

        
	}

}
